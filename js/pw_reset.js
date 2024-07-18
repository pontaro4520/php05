document.addEventListener('DOMContentLoaded', function() {
    const checkIdButton = document.getElementById('checkId');
    const step1 = document.getElementById('step1');
    const step2 = document.getElementById('step2');
    const resetForm = document.getElementById('resetForm');

    checkIdButton.addEventListener('click', function() {
        const lid = document.getElementById('lid').value;
        
        // AJAXリクエストを使用してサーバーにIDの存在を確認
        fetch('check_id.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'lid=' + encodeURIComponent(lid)
        })
        .then(response => response.json())
        .then(data => {
            if (data.exists) {
                step1.style.display = 'none';
                step2.style.display = 'block';
            } else {
                alert('指定されたIDは登録されていません。');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('エラーが発生しました。もう一度お試しください。');
        });
    });

    resetForm.addEventListener('submit', function(e) {
        const newPassword = document.getElementById('new_password').value;
        const confirmPassword = document.getElementById('confirm_password').value;
        
        if (newPassword !== confirmPassword) {
            e.preventDefault();
            alert('新しいパスワードと確認用パスワードが一致しません。');
        }
    });
});
