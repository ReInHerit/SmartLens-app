const artworkTitle = document.querySelector('#artworkTitle')
const author = document.querySelector('#author')
const detail = document.querySelector('#detailName')
const description = document.querySelector("#description")
const audioGuide = document.querySelector('#audioGuide')
const restartButton = document.querySelector('#restart')


let voices = undefined;
const synth = window.speechSynthesis
const utterThis = new SpeechSynthesisUtterance()
setTimeout(() => {
    voices = synth.getVoices()
    console.log(voices)
    utterThis.voice = voices[21];
    utterThis.lang = 'it-IT';
}, 100);


let ourText = ""

const checkBrowserCompatibility = () => {
    "speechSynthesis" in window
        ? console.log("Web Speech API supported!")
        : console.log("Web Speech API not supported :-(")
}

checkBrowserCompatibility()

let action = 1;

window.addEventListener('load', function (){
    action = 1;
})




audioGuide.addEventListener('click', function (){
    if(action == 1){
        restart.style.display = 'inline'
        ourText = "L'opera che stai guardando è "
        ourText = ourText.concat(artworkTitle.innerText)
        ourText = ourText.concat(' di ')
        ourText = ourText.concat(author.innerText)
        ourText = ourText.concat('. ed hai selezionato ')
        ourText = ourText.concat(detail.outerText)
        ourText = ourText.concat('. ')
        ourText = ourText.concat(description.outerText)
        let text = ourText.split(".")
        action = 2
        for(let i = 0; i < text.length; i++){
            let utterance = new SpeechSynthesisUtterance(text[i])
            utterance.voice = voices.filter(function(voice) { return voice.name == 'Google italiano'; })[0];
            synth.speak(utterance)
        }


    }
    else if(action == 2){
        synth.pause();
        restart.style.display = 'inline'
        action = 3
    } else {
        synth.resume();
        action = 2
    }

})

restartButton.addEventListener('click', function (){
    synth.cancel()
    ourText = "L'opera che stai guardando è "
    ourText = ourText.concat(artworkTitle.innerText)
    ourText = ourText.concat(' di ')
    ourText = ourText.concat(author.innerText)
    ourText = ourText.concat('. ed hai selezionato .')
    ourText = ourText.concat(detail.outerText)
    ourText = ourText.concat('  . !')
    ourText = ourText.concat(description.outerText)
    let text = ourText.split(".")
    action = 2
    for(let i = 0; i < text.length; i++){
        let utterance = new SpeechSynthesisUtterance(text[i])
        utterance.voice = voices.filter(function(voice) { return voice.name == 'Google italiano'; })[0];
        synth.speak(utterance)
    }
})


window.onbeforeunload = function (){
    synth.cancel();
}

