<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adding Panelist</title>
</head>
<body>

    <h1>Adding Panelist/Instructor</h1>

    <form action="#" id="add_panel" enctype="multipart/form-data">
        <label for="first_name" style="user-select: none;">First Name: </label>
        <input type="text" name="first_name" id="first_name" required >

        <label for="last_name"style="user-select: none;">Last Name: </label>
        <input type="text" name="last_name" id="last_name" required>

        <label for="email" style="user-select: none;">Email: </label>
        <input type="text" name="email" id="email" required>

        <label for="password" style="user-select: none;">Password: </label>
        <input type="password" name="password" id="password" required>
        <button type="submit">Submit</button>
    </form>

</body>
<script src="../js/adding_panelist.js"></script>

</html>