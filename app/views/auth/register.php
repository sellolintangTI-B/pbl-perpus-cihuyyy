<?php
$error = ResponseHandler::getResponse();
var_dump($error);
?>
<h1>
    register
</h1>
<form action="<?= URL ?>/auth/signup" method="POST" enctype="multipart/form-data">
    <h2>Registration Form</h2>

    <label for="id_number">ID Number</label>
    <input type="text" id="id_number" name="id_number" >

    <label for="email">Email</label>
    <input type="email" id="email" name="email" >

    <label for="password">Password</label>
    <input type="password" id="password" name="password" >

    <label for="first_name">First Name</label>
    <input type="text" id="first_name" name="first_name" >

    <label for="last_name">Last Name</label>
    <input type="text" id="last_name" name="last_name">

    <label for="phone_number">Phone Number</label>
    <input type="tel" id="phone_number" name="phone_number" pattern="[0-9]{10,15}" placeholder="e.g. 081234567890" >

    <label for="role">Role</label>
    <select id="role" name="role" >
        <option value="">-- Select Role --</option>
        <option value="Mahasiswa">Mahasiswa</option>
        <option value="Dosen">Dosen</option>
    </select>

    <input type="file" name="activation_proof" id="">

    <button type="submit">Register</button>
</form>