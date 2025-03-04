const form = document.querySelector(".form form"),
submitbtn = form.querySelector(".submit input"),
errortxt = form.querySelector(".error-text");

form.onsubmit = (e) => {
    e.preventDefault(); // Prevents form submissionCall the submit function manually
};

submitbtn.onclick = () => {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "./signup.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let data = xhr.response;
                if (data === "Success") {
                    location.href = "./verify.php";
                } else {
                    errortxt.textContent = data;
                    errortxt.style.display = "block";
                }
            }
        }
    };
    let formData = new FormData(form);
    xhr.send(formData);
};
