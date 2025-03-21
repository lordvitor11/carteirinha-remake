export function showNavbarNotification(popup2, overlay2, body) {
    overlay2.style.display = 'block';
    popup2.style.display = 'block';
    popup2.classList.add('open');
    body.classList.add('active');
}

export function closeNavbarNotification(popup2, overlay2, body) {
    popup2.classList.remove('open');
    popup2.classList.add('closed');
    setTimeout(() => {
        overlay2.style.display = 'none';
        popup2.style.display = 'none';
        popup2.classList.remove('closed')
        body.classList.remove('active');
    }, 500);
}

export function addContent(notificationItems, notificationContent) {
    notificationItems.forEach((item, index) => {
        let clone = item.cloneNode(true)
        clone.style.animationDelay = `${index * 0.2}s`;
        notificationContent.appendChild(clone);
        
        setTimeout(() => {
            clone.classList.add('visible');
        }, index * 200);
    });
}

export function showContent(popup2) {
    popup2.classList.remove('open');
    popup2.classList.add('expanded');
}

export function backContent(popup2) {
    popup2.classList.remove('expanded');
    popup2.classList.add('open');
}

export function showNotification(titulo, descricao, feedback) {
    const overlay = document.querySelector('.overlay'); 
    const popup = document.querySelector('.popup');
    const title = document.querySelector('.title');
    const desc = document.querySelector('.desc');
    const feedbackTemplate = document.querySelector('#feedback');
    const closeBtn = popup.querySelector('#close');

    overlay.classList.add('active');
    popup.classList.add('active');
    closeBtn.classList.remove('close-btn-2')
    closeBtn.textContent = 'Entendido';

    // if (feedback) {
    //     const section = document.createElement('section');

    //     closeBtn.classList.add('close-btn-2');
    //     closeBtn.textContent = 'Fechar';
    //     section.classList.add('feedback');
    //     section.innerHTML = feedbackTemplate.innerHTML;
    //     popup.querySelector('main').appendChild(section);

    //     const stars = section.querySelectorAll('.estrela');
    //     let selectedRating = 0;
    
    //     if (stars.length > 0) {
    //         stars.forEach((star, index) => {
    //             star.addEventListener('mouseover', () => {
    //               updateStars(index + 1);
    //             });
          
    //             star.addEventListener('click', () => {
    //               selectedRating = index + 1;
    //               updateStars(selectedRating);
    //               sendFeedback(selectedRating);
    //             //   console.log(`Avaliação selecionada: ${selectedRating}`);
    //             });
          
    //             star.addEventListener('mouseout', () => {
    //               updateStars(selectedRating);
    //             });
    //           });
          
    //         function updateStars(rating) {
    //             stars.forEach((star, index) => {
    //                 star.classList.toggle('filled', index < rating);
    //             });
    //         }
    //     }
    // }

    title.textContent = titulo;
    desc.textContent = descricao;

    document.body.classList.add('active');

    closeBtn.addEventListener('click', function() {
        overlay.classList.remove('active');
        popup.classList.remove('active');
        popup.classList.add('close');
        setTimeout(() => {
        popup.classList.remove('close');
        document.body.classList.remove('active');
        }, 500);
    });
}

// const openPopup = document.querySelector('#open-popup');
// const popup2 = document.querySelector('#popup2');

// if (popup2 && openPopup) {
//     openPopup.addEventListener('click', function() {
//         popup2.style.display = 'block';
//         popup2.classList.add('active');

//         document.querySelector('#close').addEventListener('click', function() {
//             popup2.classList.remove('active');
//             popup2.classList.add('showOff');
//             setTimeout(() => {
//                 popup2.style.display = 'none';
//                 popup2.classList.remove('showOff')
//             }, 500);
//         });
//     });
// }