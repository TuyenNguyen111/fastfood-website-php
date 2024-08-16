function validateForm() {
    // Get form elements
    var username = document.forms["registerForm"]["username"].value;
    var email = document.forms["registerForm"]["email"].value;
    var password = document.forms["registerForm"]["password"].value;
    var confirmPassword = document.forms["registerForm"]["confirm_password"].value;

    // Regular expression for email validation
    var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;

    // Check if username is empty
    if (username === "") {
        alert("Tên đăng nhập phải được điền");
        return false;
    }

    // Check if email is empty or invalid
    if (email === "") {
        alert("Email phải được điền");
        return false;
    } else if (!emailPattern.test(email)) {
        alert("Định dạng email không hợp lệ");
        return false;
    }

    // Check if password is empty or too short
    if (password === "") {
        alert("Mật khẩu phải được điền");
        return false;
    } else if (password.length < 6) {
        alert("Mật khẩu phải ít nhất 6 ký tự");
        return false;
    }

    // Check if passwords match
    if (password !== confirmPassword) {
        alert("Mật khẩu và xác nhận mật khẩu không khớp");
        return false;
    }

    // If all validations pass
    return true;
}
