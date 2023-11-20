<?php
$conexao = new mysqli("localhost", "root", "", "hospital_antoniomiguel");

if ($conexao->connect_error) {
    die("Erro de conexão com o banco de dados: " . $conexao->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pacienteNome = $_POST["pacienteNome"];
    $medicoEspecializacao = $_POST["medicoEspecializacao"];
    $dataConsulta = $_POST["dataConsulta"];
    $horarioConsulta = $_POST["horarioConsulta"];
    $detalhesConsulta = $_POST["detalhesConsulta"];

    // Use instrução preparada para evitar injeções SQL
    $stmt = $conexao->prepare("INSERT INTO consultas (paciente_nome, medico_especializacao, data_consulta, horario_consulta, detalhes_consulta) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $pacienteNome, $medicoEspecializacao, $dataConsulta, $horarioConsulta, $detalhesConsulta);

    if ($stmt->execute()) {
        // Redireciona para a página de prontuários após o agendamento bem-sucedido
        header("Location: visualizacao_prontuarios.php");
        exit();
    } else {
        echo "<script>alert('Erro ao agendar consulta: " . $stmt->error . "');</script>";
    }

    $stmt->close();
}

$conexao->close();
?>
