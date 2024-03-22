const nextButton = document.querySelector('.btn-next');
const prevButton = document.querySelector('.btn-prev');
const steps = document.querySelectorAll('.step');
const form_steps = document.querySelectorAll('.form-step');
let active = 1;

nextButton.addEventListener('click' , () => {
    active++;
    if (active > steps.length){
        active = steps.length;
    }
    updateProgress();
})

prevButton.addEventListener('click' , () => {
    active--;
    if (active < 1 ) {
        active =1 ;
    }
    updateProgress();
})

const updateProgress = () => {
    console.log('steps.length =>' + steps.length);
    console.log('active =>' + active );

    steps.forEach((step,i) => { 
        if (i == (active-1)){
            step.classList.add('active');
            form_steps[i].classList.add('active');
            console.log('i =>' + i);
        } else {
            step.classList.remove('active');
            form_steps[i].classList.remove('active');
        }
    });

    if (active === 1) {
        prevButton.disabled = true;
    } else if (active === steps.length){
        nextButton.disabled = true;
    }else {
        prevButton.disabled = false;
        nextButton.disabled = false;
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const submitButton = document.querySelector('#meeting_submit');
    const fields = ['#meeting_reservedAt', '#meeting_floor_space', '#meeting_description', '#meeting_address'];

    submitButton.addEventListener('click', function(event) {
        let isFormValid = true;

        fields.forEach(function(fieldSelector, index) {
            const field = document.querySelector(fieldSelector);
            const stepSpan = document.querySelectorAll('.progress-steps li')[index].querySelector('p span');
            if (field && !field.value) {
                
                stepSpan.style.color = 'rgb(255, 109, 109)';
                stepSpan.style.display = 'block'; 
                isFormValid = false; 
            } else {
                
                stepSpan.style.color = 'rgb(171, 171, 171)';
          
            }
        });

        if (!isFormValid) {
            event.preventDefault(); 
            
        }
    });
});