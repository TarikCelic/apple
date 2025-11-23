const messages = document.querySelectorAll('.message')

messages.forEach(message => {
    message.addEventListener('click', () => {
        let odgovorio = message.dataset.answered
        let odgovorioImg = message.dataset.answeredimg
        let odgovor = message.dataset.answer
        let subject = message.dataset.subj
        
        let html = `<div class="msg-overlay">  
            <div class="message-view">
                <div class="message-view-first-row">  
                    <div class="answeredBy">
                        <img class='profile-pic-little' src='${odgovorioImg}'>
                        <p class='answered'>${odgovorio}</p>
                    </div>
                    <div class="subj">
                        On: <span class='subject'>${subject}</span>
                    </div>
                </div>
                <div class="message-view-second-row">
                    <p class='reply'>${odgovor}</p>
                </div>
            </div>
        </div>`

        document.body.insertAdjacentHTML('beforeend', html)
        
        const overlay = document.querySelector('.msg-overlay')
        
        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) {
                overlay.remove()
            }
        })
    })
})