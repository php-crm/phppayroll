  function showLogin() {
    document.getElementById('login-form').style.display = 'block';
    document.getElementById('forgot-form').style.display = 'none';
    document.getElementById('register-form').style.display = 'none';
  }
  function showForgot() {
    document.getElementById('login-form').style.display = 'none';
    document.getElementById('forgot-form').style.display = 'block';
    document.getElementById('register-form').style.display = 'none';
  }
  function showRegister() {
    document.getElementById('login-form').style.display = 'none';
    document.getElementById('forgot-form').style.display = 'none';
    document.getElementById('register-form').style.display = 'block';
  }

  let currentStep = 1;
  const totalSteps = 2;

  function showStep(step) {
    for(let i = 1; i <= totalSteps; i++) {
      document.getElementById(`step-${i}`).style.display = (i === step) ? 'block' : 'none';
    }
  }

  function nextStep() {
    const step1 = document.getElementById('step-1');
    const inputs = step1.querySelectorAll('input[required]');
    for(let input of inputs) {
      if(!input.value.trim()) {
        input.reportValidity();
        return;
      }
    }
    // Password matching validation
    const pwd = document.getElementById('password').value;
    const pwdConfirm = document.getElementById('password_confirm').value;
    if (pwd !== pwdConfirm) {
      alert("Passwords do not match. Please retype.");
      return;
    }

    if (currentStep < totalSteps) {
      currentStep++;
      showStep(currentStep);
    }
  }

  function prevStep() {
    if (currentStep > 1) {
      currentStep--;
      showStep(currentStep);
    }
  }

  // Initialize form on page load
  showStep(currentStep);	
