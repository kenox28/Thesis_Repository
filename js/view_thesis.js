let currentThesisFile = "";
let currentThesisId = "";
let pdfViewport = null;
let pdfOffsetX = 0;
let pdfOffsetY = 0;
let pdfPageWidth = 0;
let pdfPageHeight = 0;

let isHighlighting = false;
let highlightStart = null;
let highlights = [];
let isTextMode = false;
let textAnnotations = []; // Store {x, y, text}

let pdfDoc = null;
let currentPageNum = 1;
let totalPageCount = 1;

// Store highlights and textAnnotations per page
let highlightsByPage = {};
let textAnnotationsByPage = {};

async function showupload() {
	try {
		const res = await fetch("../../php/reviewer/reView_thesis.php");
		const data = await res.json();

		if (data.error) {
			document.getElementById(
				"userTableBody"
			).innerHTML = `<p>${data.error}</p>`;
			return;
		}

		let rows = "";
		for (const u of data) {
			const filePath = "../../assets/thesisfile/" + u.ThesisFile;

			rows += `
				<div class="upload-item" style="margin-bottom: 20px;">
					<h3>${u.title}</h3>
					<p>${u.abstract}</p>
					<embed src="${filePath}" width="600" height="400" type="application/pdf">
					<div style="display: flex; justify-content: space-between; margin-top: 10px;">
						<button onclick="updateStatus(${u.id}, 'rejected')">Reject</button>
						<button onclick="openReviseModal('${u.id}', '${u.ThesisFile}')">Revise</button>
						<button onclick="updateStatus(${u.id}, 'approved')">Approve</button>
					</div>
					<button onclick="window.location.href='view_Revise.php?thesis_id=${u.id}'" style="width: 100%; margin-top: 10px;">Revision History</button>
				</div>
			`;
		}


		document.getElementById("userTableBody").innerHTML = rows;
	} catch (error) {
		console.error("Error fetching uploads:", error);
		document.getElementById(
			"userTableBody"
		).innerHTML = `<p>Something went wrong.</p>`;
	}
}
showupload();

async function updateStatus(thesisId, status) {
	let actionText = status === "approved" ? "approve" : "reject";
	let confirmButtonText =
		status === "approved" ? "Yes, Approve" : "Yes, Reject";
	let confirmButtonColor = status === "approved" ? "#43a047" : "#e53935";

	const result = await Swal.fire({
		title: `Are you sure you want to ${actionText} this thesis?`,
		icon: "warning",
		showCancelButton: true,
		confirmButtonText: confirmButtonText,
		cancelButtonText: "Cancel",
		confirmButtonColor: confirmButtonColor,
		cancelButtonColor: "#888",
	});

	if (result.isConfirmed) {
		// Create a FormData object to send the data
		const formData = new FormData();
		formData.append("thesis_id", thesisId);
		formData.append("status", status);

		const res = await fetch("../../php/reviewer/updatethesis_status.php", {
			method: "POST",
			body: formData,
		});

		const data = await res.json();
		Swal.fire({
			icon: data.status === "success" ? "success" : "error",
			title: data.status === "success" ? "Success" : "Error",
			text: data.message,
			confirmButtonColor: "#1976a5",
		});
		if (data.status === "success") {
			showupload(); // Refresh the list
		}
	}
}

const logout = document.querySelector("#logout");
logout.onclick = function (e) {
	console.log("run");
	e.preventDefault();
	window.location.href = "../php/logout.php";
};
pdfjsLib.GlobalWorkerOptions.workerSrc =
	"https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js";

function openReviseModal(thesisId, thesisFile) {
	currentThesisFile = thesisFile;
	currentThesisId = thesisId;
	document.getElementById("reviseModal").style.display = "flex";
	document.getElementById("modal_thesis_id").value = thesisId;

	pdfjsLib.GlobalWorkerOptions.workerSrc =
		"https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js";

	var url = "../../assets/thesisfile/" + thesisFile;
	var container = document.getElementById("pdf-container");
	console.log("Loading PDF from:", url);

	// Remove only the PDF canvas, not the highlight canvas
	const pdfCanvas = container.querySelector("canvas:not(#highlight-canvas)");
	if (pdfCanvas) container.removeChild(pdfCanvas);

	// Also clear highlights
	highlights = [];
	const highlightCanvas = document.getElementById("highlight-canvas");
	if (highlightCanvas) {
		const ctx = highlightCanvas.getContext("2d");
		ctx.clearRect(0, 0, highlightCanvas.width, highlightCanvas.height);
		highlightCanvas.width = 800;
		highlightCanvas.height = 800;
		highlightCanvas.style.width = "800px";
		highlightCanvas.style.height = "800px";
	}

	pdfjsLib.getDocument(url).promise.then(function (pdf) {
		pdfDoc = pdf;
		totalPageCount = pdf.numPages;
		currentPageNum = 1;
		highlightsByPage = {};
		textAnnotationsByPage = {};
		renderPage(currentPageNum);
		updatePageIndicator();
	});
}
function closeReviseModal() {
	document.getElementById("reviseModal").style.display = "none";
	// Do NOT clear pdf-container's innerHTML!
}

// Optional: You can add a function to download the annotated PDF and set it as the file input value

function enableHighlightMode() {
	const highlightCanvas = document.getElementById("highlight-canvas");
	if (!highlightCanvas) {
		alert("Highlight canvas not found!");
		return;
	}
	highlightCanvas.style.pointerEvents = "auto"; // Enable mouse events

	highlightCanvas.onmousedown = function (e) {
		isHighlighting = true;
		const rect = highlightCanvas.getBoundingClientRect();
		highlightStart = { x: e.clientX - rect.left, y: e.clientY - rect.top };
	};

	highlightCanvas.onmousemove = function (e) {
		if (!isHighlighting) return;
		const rect = highlightCanvas.getBoundingClientRect();
		const ctx = highlightCanvas.getContext("2d");
		ctx.clearRect(0, 0, highlightCanvas.width, highlightCanvas.height);

		// Draw existing highlights
		for (const h of highlights) {
			ctx.fillStyle = "rgba(255,255,0,0.4)";
			ctx.fillRect(h.x, h.y, h.w, h.h);
		}

		// Draw current highlight
		const x = highlightStart.x;
		const y = highlightStart.y;
		const w = e.clientX - rect.left - x;
		const h = e.clientY - rect.top - y;
		ctx.fillStyle = "rgba(255,255,0,0.4)";
		ctx.fillRect(x, y, w, h);
	};

	highlightCanvas.onmouseup = function (e) {
		if (!isHighlighting) return;
		isHighlighting = false;
		const rect = highlightCanvas.getBoundingClientRect();
		const x = highlightStart.x;
		const y = highlightStart.y;
		const w = e.clientX - rect.left - x;
		const h = e.clientY - rect.top - y;
		highlights.push({ x, y, w, h });

		// Redraw all highlights
		const ctx = highlightCanvas.getContext("2d");
		ctx.clearRect(0, 0, highlightCanvas.width, highlightCanvas.height);
		for (const h of highlights) {
			ctx.fillStyle = "rgba(255,255,0,0.4)";
			ctx.fillRect(h.x, h.y, h.w, h.h);
		}

		highlightCanvas.style.pointerEvents = "none"; // Disable after drawing
	};
}

// Attach to the Highlight button
document.addEventListener("DOMContentLoaded", function () {
	const highlightBtn = document.querySelector('button[onclick*="highlight"]');
	if (highlightBtn) {
		highlightBtn.onclick = enableHighlightMode;
	}
});

async function saveHighlightedPDF() {
	// Store current page's annotations
	saveCurrentPageAnnotations();

	// 1. Fetch the original PDF as bytes
	const url = "../../assets/thesisfile/" + currentThesisFile;
	const existingPdfBytes = await fetch(url).then((res) => res.arrayBuffer());

	// 2. Load PDF with PDF-lib
	const pdfDocLib = await PDFLib.PDFDocument.load(existingPdfBytes);

	// 3. For each page, apply highlights and text
	for (let pageNum = 1; pageNum <= totalPageCount; pageNum++) {
		const page = pdfDocLib.getPage(pageNum - 1); // PDF-lib is 0-based

		// You need to recalculate the page size/offset for each page
		// We'll use the same logic as in renderPage
		const originalViewport = await pdfDoc
			.getPage(pageNum)
			.then((p) => p.getViewport({ scale: 1 }));
		const scale = Math.min(
			800 / originalViewport.width,
			800 / originalViewport.height
		);
		const viewport = originalViewport.clone({ scale: scale });
		const offsetX = (800 - viewport.width) / 2;
		const offsetY = (800 - viewport.height) / 2;
		const pageWidth = originalViewport.width;
		const pageHeight = originalViewport.height;

		// Helper for coordinate conversion
		function pageCanvasToPdfCoords(x, y) {
			const pdfX = ((x - offsetX) / viewport.width) * pageWidth;
			const pdfY = ((y - offsetY) / viewport.height) * pageHeight;
			return { x: pdfX, y: pdfY };
		}

		const pageHighlights = highlightsByPage[pageNum] || [];
		const pageTexts = textAnnotationsByPage[pageNum] || [];

		pageHighlights.forEach((h) => {
			const start = pageCanvasToPdfCoords(h.x, h.y);
			const end = pageCanvasToPdfCoords(h.x + h.w, h.y + h.h);
			const rectX = start.x;
			const rectY = pageHeight - end.y;
			const rectW = end.x - start.x;
			const rectH = end.y - start.y;

			page.drawRectangle({
				x: rectX,
				y: rectY,
				width: rectW,
				height: rectH,
				color: PDFLib.rgb(1, 1, 0),
				opacity: 0.4,
				borderColor: PDFLib.rgb(1, 1, 0),
			});
		});

		pageTexts.forEach((t) => {
			const pos = pageCanvasToPdfCoords(t.x, t.y);
			page.drawText(t.text, {
				x: pos.x,
				y: pageHeight - pos.y,
				size: 12,
				color: PDFLib.rgb(0, 0, 0),
			});
		});
	}

	// 4. Save the PDF as a Blob
	const pdfBytes = await pdfDocLib.save();
	const blob = new Blob([pdfBytes], { type: "application/pdf" });

	// 5. Upload the Blob using FormData
	const formData = new FormData();
	formData.append("thesis_id", currentThesisId);
	formData.append("revised_pdf", blob, "revised.pdf");

	const res = await fetch("../../php/reviewer/revise_upload.php", {
		method: "POST",
		body: formData,
	});
	const result = await res.json();
	alert(result.message);
	if (result.status === "success") {
		closeReviseModal();
		showupload();
	}
}

function enableTextMode() {
	isTextMode = true;
	const highlightCanvas = document.getElementById("highlight-canvas");
	highlightCanvas.style.pointerEvents = "auto";

	highlightCanvas.onmousedown = function (e) {
		if (!isTextMode) return;
		const rect = highlightCanvas.getBoundingClientRect();
		const x = e.clientX - rect.left;
		const y = e.clientY - rect.top;
		const userText = prompt("Enter text to add:");
		if (userText) {
			textAnnotations.push({ x, y, text: userText });
			// Draw the text on the overlay for preview
			const ctx = highlightCanvas.getContext("2d");
			ctx.font = "12px Arial";
			ctx.fillStyle = "rgba(0,0,0,0.8)";
			ctx.fillText(userText, x, y);
		}
		highlightCanvas.style.pointerEvents = "none";
		isTextMode = false;
	};
}

function canvasToPdfCoords(x, y) {
	// Remove the offset of the centered PDF page in the canvas
	const pdfX = ((x - pdfOffsetX) / pdfViewport.width) * pdfPageWidth;
	const pdfY = ((y - pdfOffsetY) / pdfViewport.height) * pdfPageHeight;
	return { x: pdfX, y: pdfY };
}

function renderPage(pageNum) {
	var container = document.getElementById("pdf-container");
	// Remove only the PDF canvas, not the highlight canvas
	const pdfCanvas = container.querySelector("canvas:not(#highlight-canvas)");
	if (pdfCanvas) container.removeChild(pdfCanvas);

	pdfDoc.getPage(pageNum).then(function (page) {
		const originalViewport = page.getViewport({ scale: 1 });
		const scale = Math.min(
			800 / originalViewport.width,
			800 / originalViewport.height
		);
		const viewport = page.getViewport({ scale: scale });

		var canvas = document.createElement("canvas");
		var context = canvas.getContext("2d");
		canvas.width = 800;
		canvas.height = 800;
		canvas.style.width = "800px";
		canvas.style.height = "800px";
		container.appendChild(canvas);

		// Center the PDF page in the 800x800 canvas
		context.save();
		context.clearRect(0, 0, 800, 800);
		const offsetX = (800 - viewport.width) / 2;
		const offsetY = (800 - viewport.height) / 2;
		context.translate(offsetX, offsetY);

		var renderContext = {
			canvasContext: context,
			viewport: viewport,
		};
		page.render(renderContext).promise.then(() => {
			context.restore();
		});

		pdfViewport = viewport;
		pdfOffsetX = offsetX;
		pdfOffsetY = offsetY;
		pdfPageWidth = originalViewport.width;
		pdfPageHeight = originalViewport.height;

		// Restore highlights and text for this page
		highlights = highlightsByPage[pageNum] || [];
		textAnnotations = textAnnotationsByPage[pageNum] || [];
		redrawHighlightsAndText();
	});
}

function prevPage() {
	if (currentPageNum <= 1) return;
	saveCurrentPageAnnotations();
	currentPageNum--;
	renderPage(currentPageNum);
	updatePageIndicator();
}

function nextPage() {
	if (currentPageNum >= totalPageCount) return;
	saveCurrentPageAnnotations();
	currentPageNum++;
	renderPage(currentPageNum);
	updatePageIndicator();
}

function updatePageIndicator() {
	document.getElementById(
		"pageIndicator"
	).textContent = `Page ${currentPageNum} of ${totalPageCount}`;
}

function saveCurrentPageAnnotations() {
	highlightsByPage[currentPageNum] = highlights.slice();
	textAnnotationsByPage[currentPageNum] = textAnnotations.slice();
}

function redrawHighlightsAndText() {
	const highlightCanvas = document.getElementById("highlight-canvas");
	const ctx = highlightCanvas.getContext("2d");
	ctx.clearRect(0, 0, highlightCanvas.width, highlightCanvas.height);
	for (const h of highlights) {
		ctx.fillStyle = "rgba(255, 255, 0, 0.63)";
		ctx.fillRect(h.x, h.y, h.w, h.h);
	}
	for (const t of textAnnotations) {
		ctx.font = "12px Arial";
		ctx.fillStyle = "rgba(0,0,0,0.8)";
		ctx.fillText(t.text, t.x, t.y);
	}
}
