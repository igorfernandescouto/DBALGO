document.addEventListener("DOMContentLoaded", function() {
  
    const classSelect = document.getElementById('classe');
    const selectedClassSpan = document.getElementById('selectedClass');
    const shapeContainer = document.getElementById('shapeContainer');
    
    classSelect.addEventListener('change', function() {
      const selectedClass = classSelect.value;
      selectedClassSpan.textContent = classSelect.options[classSelect.selectedIndex].text;
    
      // Volta pro shape padrão
      shapeContainer.className = 'shape';
    
      // Muda o shape baseado na classe
      switch (selectedClass) {
        case 'guerreiro':
          shapeContainer.classList.add('square');
          break;
        case 'mago':
          shapeContainer.classList.add('circle');
          break;
        case 'arqueiro':
          shapeContainer.classList.add('triangle');
          break;
        case 'paladino':
          shapeContainer.classList.add('hexagon');
          break;
        case 'ladino':
          shapeContainer.classList.add('triangle');
          break;
        case 'clerigo':
          shapeContainer.classList.add('pentagon');
          break;
        default:
          shapeContainer.classList.add('square');  // O Padrão é um quadrado
      }
    });
    });