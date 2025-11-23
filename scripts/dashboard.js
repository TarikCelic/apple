const managePages = document.querySelector('.top')
const pages = document.querySelector('.bottom')
const managePagesArrow = document.querySelector('.arrow')
const main = document.querySelector('.main')

const btn = document.querySelectorAll('.jsitem')

const answerModal = document.querySelector('.answerModal')
const questSubj = document.querySelector('.questionSubj')
const questAsked = document.querySelector('.questionAskd')
const questionDate = document.querySelector('.questionDate')
const questionTxt = document.querySelector('.questionTxt')
const questionID = document.querySelector('.question_id')

const answerLater = document.querySelector('.answer-later')

managePages.addEventListener('click' ,() => {
    pages.classList.toggle("show")
    managePagesArrow.classList.toggle('show-arrow')
})
let page = ''
btn.forEach(button => {
    button.addEventListener('click' , async () =>{
        let toTrim = button.textContent
        page = toTrim.trim()

        if(page === 'Answer Questions'){
            const res = await fetch("./api/messages.php")

            if(!res.ok){
                throw new Error ('Greska')
            }

            const questions = await res.json();

            let html = `<h1>Questions</h1>
                        <p>Here you can see all unanswered questions</p>`;

            questions.forEach((question) =>{
               html += `
                        <div class="question-card" data-id="${question.id}" data-subject="${question.subject}" data-date="${question.created_at}" data-asked="${question.name}" data-message="${question.message}">
                            <p class="subject">${question.subject}</p>
                            <button class="answer-question">Answer Question</button>
                        </div>     
               `
            })
            main.innerHTML = html;
            const answer = document.querySelectorAll('.answer-question') 

            answer.forEach((e) => {
                e.addEventListener('click' , () => {
                    let page = e.closest('.question-card')
                    let q = page.dataset.message
                    let subj = page.dataset.subject
                    let aasked = page.dataset.asked
                    let date = page.dataset.date
                    let q_id = page.dataset.id
                    answerModal.classList.remove('hide')
                    questSubj.textContent = subj;
                    questionTxt.textContent = q
                    questAsked.textContent = aasked
                    questionDate.textContent = date
                    questionID.value = q_id
                })
            })
        }
    })
});
answerLater.addEventListener('click', ()=>{
    answerModal.classList.add('hide')
})