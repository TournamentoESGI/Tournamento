setInterval(function() {
    fetch('?page=check_logout')
        .then(response => response.text())
        .then(data => {
            
            if (data.trim() === 'LOGOUT') {
                if (!window.location.href.includes('?page=login')) {
                    window.location.href = '?page=login'; 
                }
            }
        });
}, 3000);