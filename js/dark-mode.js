// dark-mode.js
const toggleButton = document.getElementById('toggle-theme');
const body = document.body;

// �������� ���������� ����
if (localStorage.getItem('theme') === 'dark') {
    body.classList.add('dark-theme');
}

// ��� ����� � ����������� ����
toggleButton.addEventListener('click', () => {
    body.classList.toggle('dark-theme');

    // ��������� �����
    if (body.classList.contains('dark-theme')) {
        localStorage.setItem('theme', 'dark');
    } else {
        localStorage.removeItem('theme');
    }
});
