// Smooth scrolling for navigation links
// Modal Functions
function showLoginModal() {
    document.getElementById('loginModal').style.display = 'block';
}

function showSignupModal() {
    document.getElementById('signupModal').style.display = 'block';
}

function closeLoginModal() {
    document.getElementById('loginModal').style.display = 'none';
}

function closeSignupModal() {
    document.getElementById('signupModal').style.display = 'none';
}

function switchToSignup() {
    closeLoginModal();
    showSignupModal();
}

function switchToLogin() {
    closeSignupModal();
    showLoginModal();
}

// Close modals when clicking outside
window.onclick = function(event) {
    const loginModal = document.getElementById('loginModal');
    const signupModal = document.getElementById('signupModal');
    
    if (event.target === loginModal) {
        closeLoginModal();
    }
    if (event.target === signupModal) {
        closeSignupModal();
    }
}

// Form validation for signup
document.getElementById('signupModal')?.addEventListener('submit', function(e) {
    const password = document.getElementById('signupPassword').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    
    if (password !== confirmPassword) {
        e.preventDefault();
        alert('Passwords do not match!');
        return false;
    }
    
    if (password.length < 6) {
        e.preventDefault();
        alert('Password must be at least 6 characters long!');
        return false;
    }
    
    return true;
});