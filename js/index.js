document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('priceData');

    form.addEventListener('submit', function(event) {
        if (!validateForm()) {
            event.preventDefault();
        }
    });

    function validateForm() {
        let isValid = true;
        const fields = {
            date: {
                element: document.getElementById('date'),
                errorMessage: '見積取得日を入力してください'
            },
            material: {
                element: document.querySelector('input[name="material"]:checked'),
                errorMessage: '鋼種を選択してください'
            },
            form: {
                element: document.querySelector('input[name="form"]:checked'),
                errorMessage: '材種を選択してください'
            },
            thickness: {
                element: document.getElementById('thickness'),
                errorMessage: '有効な板厚を入力してください',
                validator: (value) => !isNaN(value) && parseFloat(value) > 0
            },
            size: {
                element: document.getElementById('size'),
                errorMessage: 'サイズを正しい形式で入力してください（例：100x200）',
                validator: (value) => /^\d+x\d+$/.test(value)
            },
            price: {
                element: document.getElementById('price'),
                errorMessage: '有効な金額を入力してください',
                validator: (value) => !isNaN(value) && parseInt(value) >= 0
            }
        };

        for (const [fieldName, field] of Object.entries(fields)) {
            const value = field.element ? field.element.value : null;
            if (!value || (field.validator && !field.validator(value))) {
                showError(field.element, field.errorMessage);
                isValid = false;
            } else {
                clearError(field.element);
            }
        }

        return isValid;
    }

    function showError(element, message) {
        clearError(element);
        const errorElement = document.createElement('div');
        errorElement.className = 'error-message';
        errorElement.textContent = message;
        element.parentNode.insertBefore(errorElement, element.nextSibling);
        element.classList.add('error');
    }

    function clearError(element) {
        const errorElement = element.parentNode.querySelector('.error-message');
        if (errorElement) {
            errorElement.remove();
        }
        element.classList.remove('error');
    }

    // 動的なフィールドの表示/非表示（オプション）
    const formRadios = document.querySelectorAll('input[name="form"]');
    const thicknessField = document.getElementById('thickness').closest('.form-group');
    const sizeField = document.getElementById('size').closest('.form-group');

    formRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'sheetMetal' || this.value === 'flatBar') {
                thicknessField.style.display = 'block';
                sizeField.style.display = 'block';
            } else if (this.value === 'squarePipe' || this.value === 'roundPipe') {
                thicknessField.style.display = 'none';
                sizeField.style.display = 'block';
            } else {
                thicknessField.style.display = 'none';
                sizeField.style.display = 'none';
            }
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    // 既存のコード...

    // 見積取得日のデフォルト値を設定
    const dateInput = document.getElementById('date');
    if (dateInput) {
        const today = new Date();
        const year = today.getFullYear();
        const month = String(today.getMonth() + 1).padStart(2, '0');
        const day = String(today.getDate()).padStart(2, '0');
        dateInput.value = `${year}-${month}-${day}`;
    }

    // 既存のコード...
});