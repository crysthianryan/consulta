<?php
// Arquivo registrar_consulta.php

// Verifica se a requisição é do tipo POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtém os dados da requisição
    $data = json_decode(file_get_contents("php://input"), true);

    // Conecta ao banco de dados (substitua os valores conforme necessário)
    $conexao = new mysqli("localhost", "seu_usuario", "sua_senha", "hospital_antoniomiguel");

    // Verifica a conexão com o banco de dados
    if ($conexao->connect_error) {
        die("Erro de conexão com o banco de dados: " . $conexao->connect_error);
    }

    // Prepara a instrução SQL para inserção
    $stmt = $conexao->prepare("INSERT INTO consultas (paciente_nome, medico_especializacao, data_consulta, horario_consulta, detalhes_consulta) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $data['pacienteNome'], $data['medicoEspecializacao'], $data['dataConsulta'], $data['horarioConsulta'], $data['detalhesConsulta']);

    // Executa a instrução SQL
    if ($stmt->execute()) {
        $response = array('success' => true, 'message' => 'Consulta registrada com sucesso!');
    } else {
        $response = array('success' => false, 'message' => 'Erro ao registrar consulta: ' . $stmt->error);
    }

    // Fecha a instrução e a conexão com o banco de dados
    $stmt->close();
    $conexao->close();

    // Retorna a resposta em formato JSON
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // Se a requisição não for do tipo POST, retorna um erro
    header('HTTP/1.1 405 Method Not Allowed');
    echo 'Método não permitido';
}
?>
