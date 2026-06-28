let buffer = "";

document.addEventListener("keydown", (e) => {
    buffer += e.key.toLowerCase();

    if (buffer.includes("matrix")) {
        document.body.classList.add("matrix-mode");
        alert("Mode Matrix activé !");
    }

    if (buffer.length > 20) buffer = buffer.slice(-10);
});
