document.getElementById('rega').addEventListener('submit',
    function (event) {
        // loeme tekstikastidest kasutaja sisestatud andmed
        var pw1 = document.getElementById('password-id').value;
        var pw2 = document.getElementById('password2-id').value;

        if (pw1!==pw2) {
			event.preventDefault();
            alert('Vigased vaartused!');
            return;
        }else{
			return true;}

    });