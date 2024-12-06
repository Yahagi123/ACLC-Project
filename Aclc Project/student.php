<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="student_form">
        <form action="student.php" method="POST">
        <div class="label_container">
             <label for="image">image</label>
             <input type="file" name="Image" id="Image">
            </div>
            <div class="label_container">
                <label for="Name">Student_Name</label> 
                <input type="text" name="Name" id="Name">
            </div>
            <div class="label_container">
                <label for="USN">USN</label>
                <input type="text" name="USN" id="USN">
            </div>
            <div class="label_container">
                <label for="Course">Course</label>
                <input type="text" name="Course" id="Course">
            </div>
            <div class="label_container">
                <label for="Year">Year</label>
                <input type="Text" name="year" id="year">
            </div>
            <div class="submit">
                <input type="submit" value="Create" name="Create">
                <span><?php echo $Create ?></span>
                </div>
        </form>
    </div>
</body>
</html>