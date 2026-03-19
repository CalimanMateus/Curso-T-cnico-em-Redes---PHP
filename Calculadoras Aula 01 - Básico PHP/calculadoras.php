<?php
if (isset($_POST['calcular_simples'])) {
    // Verificar se foi digitado manualmente ou usado os botões
    $expressao = '';
    
    if (!empty($_POST['expressao_manual'])) {
        $expressao = $_POST['expressao_manual'];
    } elseif (!empty($_POST['expressao'])) {
        $expressao = $_POST['expressao'];
    }
    
    if (!empty($expressao)) {
        try {
            // Substituir sqrt() para eval() funcionar
            $expressao_calculavel = str_replace('sqrt(', 'sqrt(', $expressao);
            
            // Criar uma função segura para eval
            $resultado = 0;
            $erro = '';
            
            // Processar raiz quadrada
            if (strpos($expressao_calculavel, 'sqrt(') !== false) {
                // Extrair o número dentro de sqrt()
                preg_match('/sqrt\(([^)]+)\)/', $expressao_calculavel, $matches);
                if (isset($matches[1])) {
                    $numero = floatval($matches[1]);
                    if ($numero < 0) {
                        $erro = "Erro: Não existe raiz quadrada de número negativo!";
                    } else {
                        $resultado = sqrt($numero);
                        $expressao_calculavel = str_replace($matches[0], $resultado, $expressao_calculavel);
                    }
                }
            }
            
            if (!$erro) {
                // Calcular expressões matemáticas básicas
                if (preg_match('/^[\d\+\-\*\/\.\s]+$/', $expressao_calculavel)) {
                    $resultado = eval("return $expressao_calculavel;");
                    echo "<div class='resultado'>{$expressao} = <span class='resultado-valor'>{$resultado}</span></div>";
                } else {
                    echo "<div class='resultado'>{$expressao} = <span class='resultado-valor'>{$resultado}</span></div>";
                }
            }
            
            if ($erro) {
                echo "<div class='resultado' style='border-left-color: #dc3545; color: #dc3545;'>{$erro}</div>";
            }
            
        } catch (Exception $e) {
            echo "<div class='resultado' style='border-left-color: #dc3545; color: #dc3545;'>Erro na expressão matemática!</div>";
        }
    }
}

if (isset($_POST['calcular_area_quadrado'])) {
    $lado = floatval($_POST['lado_quadrado']);
    $area = $lado * $lado;
    echo "<div class='resultado'>Área: <span class='resultado-valor'>{$area} unidades²</span></div>";
}

if (isset($_POST['calcular_area_retangulo'])) {
    $base = floatval($_POST['base_retangulo']);
    $altura = floatval($_POST['altura_retangulo']);
    $area = $base * $altura;
    echo "<div class='resultado'>Área: <span class='resultado-valor'>{$area} unidades²</span></div>";
}

if (isset($_POST['calcular_area_triangulo'])) {
    $base = floatval($_POST['base_triangulo']);
    $altura = floatval($_POST['altura_triangulo']);
    $tipo = $_POST['tipo_triangulo'];
    $area = ($base * $altura) / 2;
    echo "<div class='resultado'>Área do triângulo {$tipo}: <span class='resultado-valor'>{$area} unidades²</span></div>";
}

if (isset($_POST['calcular_circulo'])) {
    $raio = floatval($_POST['raio']);
    $area = pi() * $raio * $raio;
    $circunferencia = 2 * pi() * $raio;
    echo "<div class='resultado'>";
    echo "Área: <span class='resultado-valor'>" . number_format($area, 2) . " unidades²</span><br>";
    echo "Circunferência: <span class='resultado-valor'>" . number_format($circunferencia, 2) . " unidades</span>";
    echo "</div>";
}

if (isset($_POST['calcular_perimetro'])) {
    $forma = $_POST['forma_perimetro'];
    $lado1 = floatval($_POST['lado1_perimetro']);
    $lado2 = floatval($_POST['lado2_perimetro']);
    $lado3 = floatval($_POST['lado3_perimetro']);
    
    $perimetro = 0;
    switch ($forma) {
        case 'quadrado':
            $perimetro = 4 * $lado1;
            break;
        case 'retangulo':
            $perimetro = 2 * ($lado1 + $lado2);
            break;
        case 'triangulo':
            $perimetro = $lado1 + $lado2 + $lado3;
            break;
    }
    echo "<div class='resultado'>Perímetro do {$forma}: <span class='resultado-valor'>{$perimetro} unidades</span></div>";
}

if (isset($_POST['calcular_trapezio'])) {
    $base_maior = floatval($_POST['base_maior']);
    $base_menor = floatval($_POST['base_menor']);
    $altura = floatval($_POST['altura_trapezio']);
    $area = (($base_maior + $base_menor) * $altura) / 2;
    echo "<div class='resultado'>Área do trapézio: <span class='resultado-valor'>{$area} unidades²</span></div>";
}

if (isset($_POST['calcular_losango'])) {
    $diagonal_maior = floatval($_POST['diagonal_maior']);
    $diagonal_menor = floatval($_POST['diagonal_menor']);
    $area = ($diagonal_maior * $diagonal_menor) / 2;
    echo "<div class='resultado'>Área do losango: <span class='resultado-valor'>{$area} unidades²</span></div>";
}
?>
