function updateLineNumbers() {
    const codigoElement = document.getElementById('Codigo');
    const lineNumbersElement = document.getElementById('lineNumbers');
    const lines = codigoElement.value.split('\n').length;

    lineNumbersElement.innerHTML = Array.from({ length: lines }, (_, i) => i + 1).join('\n');
}

function echo(message) {
    const outputElement = document.getElementById('output');
    outputElement.textContent += message + "\n";
}

function Compilar() {
    const codigoElement = document.getElementById('Codigo');
    const outputElement = document.getElementById('output');
    const codigo = codigoElement.value.split('\n');

    outputElement.textContent = "";
    
    // Redefinir console.log para capturar la salida
    console.log = echo;

    for (let i = 0; i < codigo.length; i++) {
        const trimmedLine = codigo[i].trim();
        
        if (trimmedLine.length > 0 && !trimmedLine.endsWith(';')) {
            outputElement.textContent += `Error en la línea ${i + 1}: Falta punto y coma al final de la línea\n`;
            break;
        }

        try {
            eval(codigo[i]);
        } catch (error) {
            outputElement.textContent += `Error en la línea ${i + 1}: ${error.message}\n`;
            break;
        }
    }
}

document.addEventListener('DOMContentLoaded', (event) => {
    document.getElementById('compilarButton').addEventListener('click', Compilar);
    updateLineNumbers();
});