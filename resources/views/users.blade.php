<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="{{url('/users/submit')}}" method="POST">
        @csrf
        <div class="form-group">
        <label for="first_name">First name</label>
        <input type="text" name="users[0][first_name]">
        <label for="last_name">Last name</label>
        <input type="text" name="users[0][last_name]">
        </div>
        <div class="form-group">
            <label for="first_name">First name</label>
            <input type="text" name="users[1][first_name]">
            <label for="last_name">Last name</label>
            <input type="text" name="users[1][last_name]">
        </div>
        <input type="submit" id="submitButton" value="Submit" />
      </form>
      <button id="addMoreUsers"> Add more </button>
      <script src="{{ url('/js/app.js') }}"></script>
</body>
</html>
