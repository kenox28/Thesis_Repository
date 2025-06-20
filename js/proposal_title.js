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

function capitalize(str) {
	if (!str) return "";
	return str.charAt(0).toUpperCase() + str.slice(1).toLowerCase();
}

async function showupload() {
	const res = await fetch("../../php/reviewer/show_titleproposal.php");
	const data = await res.json();

	if (data.error) {
		document.getElementById("userTableBody").innerHTML = `<p>${data.error}</p>`;
		return;
	}

	const permissions = data.permissions || [];
	const uploads = data.uploads || [];

	console.log("Permissions received:", permissions);

	// Add search bar and table container
	let html = `
	<div style="display:flex;justify-content:flex-end;margin-bottom:1.2rem;">
		<input id="proposalSearchInput" type="text" placeholder="Search by name or title..." style="width:320px;padding:0.7rem 1.2rem;border-radius:24px;border:1.5px solid #1976a5;font-size:1.08rem;background:#f7faff;outline:none;box-shadow:0 2px 8px #cadcfc22;">
	</div>
	<div class="proposal-table-container">
		<table class="proposal-table">
			<thead>
				<tr>
					<th>Profile</th>
					<th>Name</th>
					<th>Title</th>
					<th>Message</th>
					<th>Actions</th>
				</tr>
			</thead>
		</table>
		<div id="proposalTableScroll" style="max-height:500px;overflow-y:auto;">
			<table class="proposal-table" style="border-top:none;">
				<tbody id="proposalTableBody"></tbody>
			</table>
		</div>
	</div>`;
	document.getElementById("userTableBody").innerHTML = html;

	// Render table rows
	function renderRows(filteredData) {
		let rows = "";
		for (const u of filteredData) {
			const filePath = "../../assets/thesisfile/" + u.ThesisFile;
			const profileImg = "../../assets/ImageProfile/" + u.profileImg;
			const rowId = `rowmsg_${u.id}`;
			let rejectBtn = "";
			if (permissions.includes("reject")) {
				rejectBtn = `<button onclick="updateStatus(${u.id}, 'rejected', document.getElementById('${rowId}').value); event.stopPropagation();" class="btn-action reject"><i class='fas fa-times-circle'></i> Reject </button>`;
			}
			let approveBtn = "";
			if (permissions.includes("approve")) {
				approveBtn = `<button onclick="updateStatus(${u.id}, 'continue', document.getElementById('${rowId}').value); event.stopPropagation();" class="btn-action approve"><i class='fas fa-check-circle'></i> Approve </button>`;
			}
			rows += `
				<tr>
					<td style="text-align:center;">
						<img src="${profileImg}" alt="Profile Image" class="proposal-profile-img">
					</td>
					<td style="font-weight:600;color:#1976a5;">
						${capitalize(u.lname)}, ${capitalize(u.fname)}
					</td>
					<td style="cursor:pointer;color:#1976a5;font-weight:600;" class="thesis-title"
						data-title="${encodeURIComponent(u.title)}"
						data-abstract="${encodeURIComponent(u.abstract)}"
						data-owner="${encodeURIComponent(u.lname + ", " + u.fname)}"
						data-file="${filePath}">
						${u.title}
					</td>
					<td>
						<input type="text" id="${rowId}" name="message" placeholder="Message to student..."
							style="width:99%;padding:7px 10px;border:1.5px solid #1976a5;border-radius:6px;font-size:1rem;outline:none;">
					</td>
					<td>
						${rejectBtn}
						${approveBtn}
					</td>
				</tr>
			`;
		}
		document.getElementById("proposalTableBody").innerHTML = rows;

		// Add modal open logic for .thesis-title
		document.querySelectorAll(".thesis-title").forEach((titleElem) => {
			titleElem.addEventListener("click", function (e) {
				const item = titleElem;
				const filePath = item.getAttribute("data-file");
				const title = decodeURIComponent(item.getAttribute("data-title"));
				const abstract = decodeURIComponent(item.getAttribute("data-abstract"));
				const owner = decodeURIComponent(item.getAttribute("data-owner"));

				document.getElementById("modalTitle").textContent = title;
				document.getElementById(
					"modalAbstract"
				).innerHTML = `<i class="fas fa-quote-left"></i> ${abstract}`;
				document.getElementById(
					"modalOwner"
				).innerHTML = `<i class="fas fa-user-graduate"></i> <span>${owner}</span>`;
				document.getElementById("modalPDF").src = filePath + "#toolbar=0";

				document.getElementById("thesisModal").style.display = "flex";
			});
		});
	}

	renderRows(uploads);

	// Search functionality
	document
		.getElementById("proposalSearchInput")
		.addEventListener("input", function () {
			const val = this.value.trim().toLowerCase();
			const filtered = uploads.filter(
				(u) =>
					`${u.lname}, ${u.fname}`.toLowerCase().includes(val) ||
					(u.title && u.title.toLowerCase().includes(val))
			);
			renderRows(filtered);
		});
}
showupload();

async function updateStatus(thesisId, status, message) {
	let actionText = status === "rejected" ? "Reject" : "Continue";
	let confirmButtonText =
		status === "continue" ? "Yes, Continue" : "Yes, Reject";
	let confirmButtonColor = status === "continue" ? "#43a047" : "#e53935";

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
		formData.append("message", message);

		const res = await fetch("../../php/reviewer/proposal_status.php", {
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
	if (result.status === "success") {
		Swal.fire({
			icon: "success",
			title: "Success",
			text: result.message,
			confirmButtonColor: "#1976a5",
		});
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
			ctx.font = "14px Arial";
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
		ctx.font = "14px Arial";
		ctx.fillStyle = "rgba(0,0,0,0.8)";
		ctx.fillText(t.text, t.x, t.y);
	}
}

// --- Modal close logic (add at the end of the file) ---
document.addEventListener("DOMContentLoaded", function () {
	const closeBtn = document.getElementById("closeThesisModal");
	const modal = document.getElementById("thesisModal");
	const modalPDF = document.getElementById("modalPDF");

	if (!closeBtn) {
		console.error("closeThesisModal not found");
	}
	if (!modal) {
		console.error("thesisModal not found");
	}
	if (!modalPDF) {
		console.error("modalPDF not found");
	}

	if (closeBtn && modal && modalPDF) {
		closeBtn.onclick = function () {
			modal.style.display = "none";
			modalPDF.src = "";
		};
		modal.onclick = function (e) {
			if (e.target === modal) {
				modal.style.display = "none";
				modalPDF.src = "";
			}
		};
	}
});
