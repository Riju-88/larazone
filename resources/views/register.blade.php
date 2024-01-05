<!DOCTYPE html>
<html>
<head>
    <title>Registration</title>
</head>
<body>

<h2>Register</h2>

<form method="POST" action="{{ route('submitForm') }}" enctype="multipart/form-data">
    @csrf

    <!-- Existing form fields (name, email, password) -->
    <div>
        <label for="name">Name</label>
        <input type="text" id="name" name="name" value="{{ old('name') }}" required>
    </div>

    <div>
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required>
    </div>

    <div>
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
    </div>

    <!-- Image input field -->
    <div>
        <label for="profile_image">Profile Image</label>
        <input type="file" id="profile_image" name="profile_image">
    </div>

    <button type="submit">Register</button>
</form>


</body>
</html>
