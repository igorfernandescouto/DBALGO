window.addEventListener('storage', function(event) {
    // Existing localStorage sync logic remains valid
    switch(event.key) {
        case 'selectedBackground':
            document.body.style.backgroundImage = `url('${event.newValue}')`;
            break;
        case 'diceResult':
            document.querySelector('.dice-result').textContent = event.newValue;
            break;
        case 'diceShape':
            const diceElement = document.querySelector('.dice');
            diceElement.classList.toggle('square', parseInt(event.newValue) === 6);
            diceElement.classList.toggle('hexagon', parseInt(event.newValue) !== 6);
            break;
    }
});