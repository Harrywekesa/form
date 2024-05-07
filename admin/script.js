document.getElementById("form").addEventListener("submit", (event) => {
  const form = document.getElementById("form");
  const formData = new FormData(form);

  var formOkay = "";

  for (const [key, value] of formData) {
    if (value.trim() == "") {
      // remove underscore from key
      var newKey = key.replace(/_/, " ");
      document.getElementById(key).textContent = `(provide your ${newKey})`;
      event.preventDefault();
      formOkay = false;
      return;
    } else {
      const password = formData.get('password');
      const confirmPassword = formData.get('confirm_password');
      if (password.trim() == confirmPassword.trim()) {
        formOkay = true;
        formData.delete('confirm_password');
      }
      
      document.getElementById(key).textContent = "";
      event.preventDefault();
    }
  }

  if (formOkay) {
    fetch("./process_registration.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error("Network response was not okay");
        }
        return response.clone().json();
      })
      .then((data) => {
        var response = data["response"];
        var message = document.getElementById("message");
        if (response == 0) {
          message.textContent = "Success ! Record saved";
        } else if (response == 1) {
          message.textContent = "Insert query failed !";
        } else if (response == 2) {
          message.innerHTML = "Record already exists ! Continue with application. <a href='application.php'>Application<a/>";
        } else if (response == 3) {
          message.textContent = "Supply values for all the fields";
        } else {
          message.textContent = "Error, contact admin !";
        }
      })
      .catch((error) => {
        console.error("There was a problem with the fetch operation", error);
      });
  }
});
