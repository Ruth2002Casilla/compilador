<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compilador Simple - Análisis de Sintaxis</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <h1>Compilador Simple - Análisis de Sintaxis</h1>
    <form method="POST" action="">
        <label for="code">Introduce tu código:</label><br>
        <textarea id="code" name="code" rows="20" cols="80"></textarea><br><br>
        <input type="submit" value="Compilar">
    </form>

    <?php
    // Función principal para compilar el código
    function compilarCodigo($codigo) {
        $lineas = explode("\n", $codigo);
        $errores = [];

        foreach ($lineas as $numLinea => $linea) {
            // Eliminar espacios en blanco al inicio y al final
            $linea = trim($linea);

            // Ignorar líneas vacías
            if (empty($linea)) continue;

            // Analizar la sintaxis de la línea
            $error = analizarSintaxis($linea);
            if ($error !== true) {
                $errores[] = "Error en la línea " . ($numLinea + 1) . ": " . $error;
            }
        }

        return $errores;
    }

    // Función para analizar la sintaxis de una línea de código
    function analizarSintaxis($linea) {
        // Verificar si la línea termina con un punto y coma
        if (substr($linea, -1) !== ';') {
            return "Falta un punto y coma al final de la línea.";
        }

        // Verificar si hay paréntesis balanceados
        $abiertos = substr_count($linea, '(');
        $cerrados = substr_count($linea, ')');
        if ($abiertos !== $cerrados) {
            return "Paréntesis no balanceados.";
        }

        // Verificar si hay llaves balanceadas
        $llaves_abiertas = substr_count($linea, '{');
        $llaves_cerradas = substr_count($linea, '}');
        if ($llaves_abiertas !== $llaves_cerradas) {
            return "Llaves no balanceadas.";
        }

        // Verificar si hay corchetes balanceados
        $corchetes_abiertos = substr_count($linea, '[');
        $corchetes_cerrados = substr_count($linea, ']');
        if ($corchetes_abiertos !== $corchetes_cerrados) {
            return "Corchetes no balanceados.";
        }

        // Verificar estructura de una declaración de variable
        if (preg_match('/^(int|float|string|bool)\s+\$\w+\s*=\s*[^;]+;$/', $linea) === 0) {
            return "Declaración de variable no válida.";
        }

        // Verificar estructura de una declaración de función
        if (preg_match('/^function\s+\w+\s*\([^)]*\)\s*\{?$/', $linea) === 0) {
            return "Declaración de función no válida.";
        }

        // Verificar la estructura de una sentencia if
        if (preg_match('/^if\s*\([^)]*\)\s*\{?$/', $linea) === 0) {
            return "Declaración if no válida.";
        }

        // Verificar la estructura de una sentencia for
        if (preg_match('/^for\s*\([^;]+;[^;]+;[^\)]+\)\s*\{?$/', $linea) === 0) {
            return "Declaración for no válida.";
        }

        // Verificar la estructura de una sentencia while
        if (preg_match('/^while\s*\([^)]*\)\s*\{?$/', $linea) === 0) {
            return "Declaración while no válida.";
        }

        // Verificar la estructura de una sentencia return
        if (preg_match('/^return\s+[^;]+;$/', $linea) === 0) {
            return "Declaración return no válida.";
        }

        // Verificar la estructura de un echo
        if (preg_match('/^echo\s+[^;]+;$/', $linea) === 0) {
            return "Declaración echo no válida.";
        }

        return true;
    }

    // Procesar el formulario si se ha enviado
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $codigo = $_POST['code'];
        $errores = compilarCodigo($codigo);

        if (empty($errores)) {
            echo "<p>Compilación exitosa, no se encontraron errores de sintaxis.</p>";
        } else {
            echo "<div class='error'><p>Se encontraron errores de sintaxis:</p><ul>";
            foreach ($errores as $error) {
                echo "<li>" . htmlspecialchars($error) . "</li>";
            }
            echo "</ul></div>";
        }
    }
    ?>
</body>
</html>
