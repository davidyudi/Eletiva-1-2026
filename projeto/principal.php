<?php
include('cabecalho.php');
require_once('conexao.php');

$totalMotoristas = $conexao->query("SELECT COUNT(*) FROM motoristas")->fetchColumn();
$totalVeiculos   = $conexao->query("SELECT COUNT(*) FROM Veiculos")->fetchColumn();
$totalRotas      = $conexao->query("SELECT COUNT(*) FROM rotas")->fetchColumn();
$totalViagens    = $conexao->query("SELECT COUNT(*) FROM viagens")->fetchColumn();

$viagensPorMes = $conexao->query("
    SELECT DATE_FORMAT(data_saida, '%m/%Y') AS mes,
           COUNT(*) AS total
    FROM viagens
    WHERE data_saida >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
    GROUP BY DATE_FORMAT(data_saida, '%Y-%m')
    ORDER BY DATE_FORMAT(data_saida, '%Y-%m')
")->fetchAll(PDO::FETCH_ASSOC);

$topMotoristas = $conexao->query("
    SELECT m.nome, COUNT(v.id) AS total
    FROM motoristas m
    LEFT JOIN viagens v ON v.Motoristas_id = m.id
    GROUP BY m.id, m.nome
    ORDER BY total DESC
    LIMIT 5
")->fetchAll(PDO::FETCH_ASSOC);

$topRotas = $conexao->query("
    SELECT CONCAT(r.Cidade_inicio, ' → ', r.Cidade_fim) AS rota,
           COUNT(v.id) AS total
    FROM rotas r
    LEFT JOIN viagens v ON v.rotas_id = r.id
    GROUP BY r.id
    ORDER BY total DESC
    LIMIT 5
")->fetchAll(PDO::FETCH_ASSOC);

$ultimasViagens = $conexao->query("
    SELECT m.nome AS motorista,
           ve.Placa AS placa,
           CONCAT(r.Cidade_inicio, ' - ', r.Estado_inicio, ' → ', r.Cidade_fim, ' - ', r.Estado_fim) AS rota,
           v.data_saida,
           v.data_chegada
    FROM viagens v
    INNER JOIN motoristas m  ON m.id  = v.Motoristas_id
    INNER JOIN Veiculos ve   ON ve.id = v.Veiculos_id
    INNER JOIN rotas r       ON r.id  = v.rotas_id
    ORDER BY v.data_saida DESC
    LIMIT 5
")->fetchAll(PDO::FETCH_ASSOC);

$mesesLabels  = json_encode(array_column($viagensPorMes, 'mes'));
$mesesTotais  = json_encode(array_column($viagensPorMes, 'total'));
$motNomes     = json_encode(array_column($topMotoristas, 'nome'));
$motTotais    = json_encode(array_column($topMotoristas, 'total'));
$rotaNomes    = json_encode(array_column($topRotas, 'rota'));
$rotaTotais   = json_encode(array_column($topRotas, 'total'));
?>

<div style="padding: 2rem 0 0;">

    <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(140px,1fr)); gap:12px; margin-bottom:2rem;">

        <a href="crud_motoristas.php" style="text-decoration:none;">
            <div style="background:var(--color-background-secondary); border-radius:var(--border-radius-md); padding:1rem; transition: box-shadow .15s;">
                <div style="display:flex; align-items:center; gap:8px; margin-bottom:8px;">
                    <i class="ti ti-steering-wheel" style="font-size:18px; color:var(--color-text-info);" aria-hidden="true"></i>
                    <span style="font-size:12px; color:var(--color-text-secondary);">Motoristas</span>
                </div>
                <div style="font-size:28px; font-weight:500; color:var(--color-text-primary);"><?= $totalMotoristas ?></div>
            </div>
        </a>

        <a href="crud_veiculos.php" style="text-decoration:none;">
            <div style="background:var(--color-background-secondary); border-radius:var(--border-radius-md); padding:1rem;">
                <div style="display:flex; align-items:center; gap:8px; margin-bottom:8px;">
                    <i class="ti ti-bus" style="font-size:18px; color:var(--color-text-success);" aria-hidden="true"></i>
                    <span style="font-size:12px; color:var(--color-text-secondary);">Veículos</span>
                </div>
                <div style="font-size:28px; font-weight:500; color:var(--color-text-primary);"><?= $totalVeiculos ?></div>
            </div>
        </a>

        <a href="crud_rotas.php" style="text-decoration:none;">
            <div style="background:var(--color-background-secondary); border-radius:var(--border-radius-md); padding:1rem;">
                <div style="display:flex; align-items:center; gap:8px; margin-bottom:8px;">
                    <i class="ti ti-map-route" style="font-size:18px; color:var(--color-text-warning);" aria-hidden="true"></i>
                    <span style="font-size:12px; color:var(--color-text-secondary);">Rotas</span>
                </div>
                <div style="font-size:28px; font-weight:500; color:var(--color-text-primary);"><?= $totalRotas ?></div>
            </div>
        </a>

        <a href="crud_viagem.php" style="text-decoration:none;">
            <div style="background:var(--color-background-secondary); border-radius:var(--border-radius-md); padding:1rem;">
                <div style="display:flex; align-items:center; gap:8px; margin-bottom:8px;">
                    <i class="ti ti-road" style="font-size:18px; color:var(--color-text-danger);" aria-hidden="true"></i>
                    <span style="font-size:12px; color:var(--color-text-secondary);">Viagens</span>
                </div>
                <div style="font-size:28px; font-weight:500; color:var(--color-text-primary);"><?= $totalViagens ?></div>
            </div>
        </a>

    </div>

    <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(280px,1fr)); gap:20px; margin-bottom:2rem;">

        <div style="background:var(--color-background-primary); border:0.5px solid var(--color-border-tertiary); border-radius:var(--border-radius-lg); padding:1.25rem;">
            <p style="font-size:13px; font-weight:500; color:var(--color-text-secondary); margin:0 0 1rem; text-transform:uppercase; letter-spacing:.05em;">Viagens por mês</p>
            <div style="position:relative; width:100%; height:200px;">
                <canvas id="chartMes" role="img" aria-label="Gráfico de viagens por mês">Viagens nos últimos 6 meses.</canvas>
            </div>
        </div>

        <div style="background:var(--color-background-primary); border:0.5px solid var(--color-border-tertiary); border-radius:var(--border-radius-lg); padding:1.25rem;">
            <p style="font-size:13px; font-weight:500; color:var(--color-text-secondary); margin:0 0 1rem; text-transform:uppercase; letter-spacing:.05em;">Top motoristas</p>
            <div style="position:relative; width:100%; height:200px;">
                <canvas id="chartMot" role="img" aria-label="Gráfico de top motoristas por viagens">Top 5 motoristas com mais viagens.</canvas>
            </div>
        </div>

    </div>

    <div style="background:var(--color-background-primary); border:0.5px solid var(--color-border-tertiary); border-radius:var(--border-radius-lg); padding:1.25rem; margin-bottom:2rem;">
        <p style="font-size:13px; font-weight:500; color:var(--color-text-secondary); margin:0 0 1rem; text-transform:uppercase; letter-spacing:.05em;">Rotas mais utilizadas</p>
        <div style="position:relative; width:100%; height:<?= max(120, count($topRotas) * 44 + 40) ?>px;">
            <canvas id="chartRotas" role="img" aria-label="Gráfico de rotas mais utilizadas">Top 5 rotas com mais viagens.</canvas>
        </div>
    </div>

    <div style="background:var(--color-background-primary); border:0.5px solid var(--color-border-tertiary); border-radius:var(--border-radius-lg); padding:1.25rem; margin-bottom:2rem;">
        <p style="font-size:13px; font-weight:500; color:var(--color-text-secondary); margin:0 0 1rem; text-transform:uppercase; letter-spacing:.05em;">Últimas viagens</p>

        <?php if (empty($ultimasViagens)): ?>
            <p style="color:var(--color-text-secondary); font-size:14px;">Nenhuma viagem cadastrada ainda.</p>
        <?php else: ?>
            <div style="overflow-x:auto;">
                <table style="width:100%; border-collapse:collapse; font-size:13px;">
                    <thead>
                        <tr style="border-bottom:0.5px solid var(--color-border-tertiary);">
                            <th style="text-align:left; padding:6px 10px; font-weight:500; color:var(--color-text-secondary);">Motorista</th>
                            <th style="text-align:left; padding:6px 10px; font-weight:500; color:var(--color-text-secondary);">Placa</th>
                            <th style="text-align:left; padding:6px 10px; font-weight:500; color:var(--color-text-secondary);">Rota</th>
                            <th style="text-align:left; padding:6px 10px; font-weight:500; color:var(--color-text-secondary);">Saída</th>
                            <th style="text-align:left; padding:6px 10px; font-weight:500; color:var(--color-text-secondary);">Chegada</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ultimasViagens as $v): ?>
                            <tr style="border-bottom:0.5px solid var(--color-border-tertiary);">
                                <td style="padding:8px 10px; color:var(--color-text-primary);"><?= htmlspecialchars($v['motorista']) ?></td>
                                <td style="padding:8px 10px;">
                                    <span style="background:var(--color-background-secondary); color:var(--color-text-secondary); font-size:12px; padding:2px 8px; border-radius:4px; font-family:var(--font-mono);"><?= htmlspecialchars($v['placa']) ?></span>
                                </td>
                                <td style="padding:8px 10px; color:var(--color-text-secondary);"><?= htmlspecialchars($v['rota']) ?></td>
                                <td style="padding:8px 10px; color:var(--color-text-secondary);"><?= htmlspecialchars($v['data_saida']) ?></td>
                                <td style="padding:8px 10px; color:var(--color-text-secondary);">
                                    <?= $v['data_chegada'] ? htmlspecialchars($v['data_chegada']) : '<span style="color:var(--color-text-tertiary);">—</span>' ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js"></script>
<script>
    const isDark = matchMedia('(prefers-color-scheme: dark)').matches;
    const textColor = isDark ? '#c2c0b6' : '#73726c';
    const gridColor = isDark ? 'rgba(255,255,255,0.07)' : 'rgba(0,0,0,0.07)';

    const mesesLabels = <?= $mesesLabels ?>;
    const mesesTotais = <?= $mesesTotais ?>;
    const motNomes = <?= $motNomes ?>;
    const motTotais = <?= $motTotais ?>;
    const rotaNomes = <?= $rotaNomes ?>;
    const rotaTotais = <?= $rotaTotais ?>;

    new Chart(document.getElementById('chartMes'), {
        type: 'bar',
        data: {
            labels: mesesLabels,
            datasets: [{
                label: 'Viagens',
                data: mesesTotais,
                backgroundColor: '#185FA5',
                borderRadius: 5,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: ctx => ' ' + ctx.parsed.y + ' viagens'
                    }
                }
            },
            scales: {
                x: {
                    ticks: {
                        color: textColor,
                        font: {
                            size: 11
                        },
                        autoSkip: false,
                        maxRotation: 30
                    },
                    grid: {
                        display: false
                    },
                    border: {
                        display: false
                    }
                },
                y: {
                    ticks: {
                        color: textColor,
                        font: {
                            size: 11
                        },
                        stepSize: 1
                    },
                    grid: {
                        color: gridColor
                    },
                    border: {
                        display: false
                    },
                    beginAtZero: true
                }
            }
        }
    });

    new Chart(document.getElementById('chartMot'), {
        type: 'doughnut',
        data: {
            labels: motNomes,
            datasets: [{
                data: motTotais,
                backgroundColor: ['#185FA5', '#0F6E56', '#993C1D', '#533AB7', '#854F0B'],
                borderWidth: 0,
                hoverOffset: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color: textColor,
                        font: {
                            size: 11
                        },
                        padding: 12,
                        boxWidth: 10,
                        boxHeight: 10
                    }
                },
                tooltip: {
                    callbacks: {
                        label: ctx => ' ' + ctx.label + ': ' + ctx.parsed + ' viagens'
                    }
                }
            },
            cutout: '60%'
        }
    });

    new Chart(document.getElementById('chartRotas'), {
        type: 'bar',
        data: {
            labels: rotaNomes,
            datasets: [{
                label: 'Viagens',
                data: rotaTotais,
                backgroundColor: '#0F6E56',
                borderRadius: 4,
                borderSkipped: false,
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: ctx => ' ' + ctx.parsed.x + ' viagens'
                    }
                }
            },
            scales: {
                x: {
                    ticks: {
                        color: textColor,
                        font: {
                            size: 11
                        },
                        stepSize: 1
                    },
                    grid: {
                        color: gridColor
                    },
                    border: {
                        display: false
                    },
                    beginAtZero: true
                },
                y: {
                    ticks: {
                        color: textColor,
                        font: {
                            size: 11
                        }
                    },
                    grid: {
                        display: false
                    },
                    border: {
                        display: false
                    }
                }
            }
        }
    });
</script>

<?php include('rodape.php'); ?>