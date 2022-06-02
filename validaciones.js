function validaFrm() {
    if (document.getElementById("txtNombre").value == "" ||
        document.getElementById("txtUsuario").value == "" ||
        document.getElementById("txtPwd").value == "" ||
        document.getElementById("txtRePwd").value == "" ||
        document.getElementById("txtEmail").value == "" ||
        document.getElementById("txtIndicio").value == "") {
        alert("Todos los campos son requeridos");
        return false;
    }
    else {
        if (document.getElementById("txtPwd").value != document.getElementById("txtRePwd").value) {
            alert("Las contraseñas no coinciden");
            document.getElementById("txtPwd").value = "";
            document.getElementById("txtRePwd").value = "";
            return false;
        }
        else {
            return true;
        }
    }
}

function validaLogin() {
    if (document.getElementById("txtUsuario").value == "" ||
        document.getElementById("txtPwd").value == "") {
        alert("Todos los campos son requeridos");
        return false;
    }
    return true;
}

function validaFabricante() {
    if (document.getElementById("txtNombre").value == "" ||
        document.getElementById("txtDir").value == "" ||
        document.getElementById("txtEmail").value == "" ||
        document.getElementById("txtTel").value == "") {
        alert("Todos los campos son requeridos");
        return false;

    }
    return true;
}