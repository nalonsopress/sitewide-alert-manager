document.addEventListener("DOMContentLoaded", function() {
    const closeBtn = document.getElementById("sam-close");
    if (closeBtn) {
        closeBtn.addEventListener("click", function() {
            const alertBar = document.getElementById("sam-alert");
            if (alertBar) alertBar.style.display = "none";
        });
    }
});
