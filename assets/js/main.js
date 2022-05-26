$(document).ready(async function() {
    let cursor = writeCursor();
    await sleep(1500)
    await writeText('Designer');
    $('#scroll-icon').addClass('slide-bottom');
    await sleep(1500)
    await writeText('Discover me');
    clearInterval(cursor);
    $('#home-text').addClass('hide-after')
    $('#home-logo').removeClass('hide');
});



function writeCursor() {
    return setInterval(() => {
        if ($('#home-text').hasClass('hide-after')) {
            $('#home-text').removeClass('hide-after')
            return;
        }
        $('#home-text').addClass('hide-after');
    }, 1000)
}

async function writeText(text) {
    let currentText = $('#home-text').text();
    for (var i = 0; i < currentText.length; i++) {
        let tmpText = $('#home-text').text();
        let tmpLength = $('#home-text').text().length
        await sleep(150);
        $('#home-text').text(tmpText.slice(0, tmpLength - 1));
    }
    await sleep(500);
    let textBox = $('#home-text');
    for (var i = 0; i < text.length; i++) {
        if (text[i] === ' ') {
            textBox.append('<span id="home-text-light" class="light"></span>');
            textBox = $('#home-text-light');
        }
        console.log(text[i]);
        let tmpText = textBox.text();
        console.log(tmpText + text[i]);
        await sleep(150);
        textBox.text(tmpText + text[i]);
    }

}

function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

function getRandomInt(min, max) {
    min = Math.ceil(min);
    max = Math.floor(max);
    return Math.floor(Math.random() * (max - min)) + min;
}