<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>New Idea Notification</title>
</head>
<body>
    <h1>New Idea Posted</h1>
    <p>Hello QA Coordinator</p>
    <p>A new idea has just been posted from your department</p>
    <ul>
        <li><strong>Title:</strong>{{$ideaTitle}}</li>
        <li><strong>Content:</strong>{{$ideaContent}}</li>
        <li><strong>Posted by:</strong>{{$userName}}</li>
    </ul>
    <u>Please check it out when you have the time.</u>
    <p>Sincerely,<br>ThinkSpace</p>
</body>
</html>