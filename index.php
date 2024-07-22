<?php require_once("header.php"); ?>
<section>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Eventos</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addeventModal">Cadastrar</button>
            </div>
        </div>
    </div>
    <div class="input-group mb-3" style="max-width: 300px;">
        <input type="text" class="form-control" placeholder="Pesquisar por nome" id="search-name" aria-label="Pesquisar por nome" aria-describedby="button-addon2">
        <button class="btn btn-primary" type="button" id="search-button">Buscar</button>
        <button class="btn btn-secondary" type="button" id="clear-search" style="display: none;">Limpar Filtro</button>
    </div>
    <div class="table-responsive small">
        <table class="table table-striped table-sm" id="events-table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Id</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Localização</th>
                    <th scope="col">Ver</th>
                    <th scope="col">Remover</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="8">
                        <button class="btn btn-danger btn-sm" id="massDeleteBtn" style="display: none;">Remover Selecionados</button>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
    <nav aria-label="Page navigation example" class="mt-4">
        <ul class="pagination">
        </ul>
    </nav>
</section>
<div class="modal fade" id="addeventModal" tabindex="-1" aria-labelledby="addeventModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addeventModalLabel">Cadastrar Evento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="eventoForm">
                    <div id="etapa1" class="etapa">
                        <div class="mb-3">
                            <label for="nomeEvento" class="form-label">Nome do Evento</label>
                            <input type="text" class="form-control" id="nomeEvento" required>
                        </div>
                        <div class="mb-3">
                            <label for="localEvento" class="form-label">Local do Evento</label>
                            <select class="form-select" id="localEvento" required>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="dataEvento" class="form-label">Data do Evento</label>
                            <input type="date" class="form-control" id="dataEvento" required>
                        </div>
                        <button type="button" class="btn btn-primary" id="btnEtapa1">Avançar</button>
                    </div>
                    <div id="etapa2" class="etapa" style="display:none;">
                        <h2>Confirmar players</h2>
                        <table class="table table-striped" id="playersTable">
                            <thead>
                                <tr>
                                    <th scope="col"><input type="checkbox" id="selectAll"></th>
                                    <th scope="col">Nome</th>
                                    <th scope="col">Posição</th>
                                    <th scope="col">Nível</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <div id="errorEtapa2" class="alert alert-danger" style="display:none;"></div>
                        <button type="button" class="btn btn-primary" id="btnVoltarEtapa2">Voltar</button>
                        <button type="button" class="btn btn-primary" id="btnEtapa2">Avançar</button>
                    </div>
                    <div id="etapa3" class="etapa" style="display:none;">
                        <div id="timesSorteados">
                        </div>
                        <button type="button" class="btn btn-primary" id="btnVoltarEtapa3">Voltar</button>
                        <button type="button" class="btn btn-primary" id="sortearNovamenteBtn">Sortear Novamente</button>
                        <button type="button" class="btn btn-success" id="salvarEventoBtn">Salvar Evento</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="vieweventModal" tabindex="-1" aria-labelledby="vieweventModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="vieweventModalLabel">Ver Evento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="viewEventoForm">
                    <div class="mb-3">
                        <label for="nomeEventoView" class="form-label">Nome do Evento</label>
                        <input type="text" class="form-control" id="nomeEventoView" readonly disabled>
                    </div>
                    <div class="mb-3">
                        <label for="localEventoView" class="form-label">Local do Evento</label>
                        <input type="text" class="form-control" id="localEventoView" readonly disabled>
                    </div>
                    <div class="mb-3">
                        <label for="dataEventoView" class="form-label">Data do Evento</label>
                        <input type="date" class="form-control" id="dataEventoView" readonly disabled>
                    </div>
                    <div id="timesSorteadosView"></div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        var players = [];
        var times = [];

        function atualizarTabelaPlayers(response) {
            var tabela = $('#playersTable tbody');
            tabela.empty();
            players = response.players || [];
            players.forEach((player) => {
                var row = '<tr data-index="' + player.id_player + '">' +
                '<td><input type="checkbox" class="confirmar-presenca" data-index="' + player.id_player + '"></td>' +
                '<td>' + player.name_player + '</td>' +
                '<td>' + player.position_player + '</td>' +
                '<td>' + player.level_player + '</td>' +
                '</tr>';
                tabela.append(row);
            });
        }

        function buscarPlayers() {
            $.ajax({
                url: '_php/_player/list-players-pagination.php?pageSize=10000',
                method: 'GET',
                success: function(response) {
                    atualizarTabelaPlayers(response);
                },
                error: function(xhr, status, error) {
                    console.error('Erro ao buscar players:', status, error);
                }
            });
        }

        $('#btnEtapa1').click(function() {
            var nomeEvento = $('#nomeEvento').val().trim();
            var localEvento = $('#localEvento').val();
            var dataEvento = $('#dataEvento').val();
            if (!nomeEvento || !localEvento || !dataEvento) {
                alert('Todos os campos da Etapa 1 são obrigatórios.');
                return;
            }
            buscarPlayers();
            $('#etapa1').hide();
            $('#etapa2').show();
        });

        $('#btnVoltarEtapa2').click(function() {
            $('#etapa2').hide();
            $('#etapa1').show();
        });

        function sortearTimes() {
            var confirmados = [];
            var goleirosSelecionados = [];
            $('.confirmar-presenca:checked').each(function() {
                var index = $(this).data('index');
                var player = players.find(p => p.id_player == index);
                if (player) {
                    confirmados.push(player);
                    if (player.position_player === 'GOL') {
                        goleirosSelecionados.push(player);
                    }
                }
            });
            var numeroplayersPorTime = parseInt(prompt('Defina o número de jogadores por time (mínimo de 4 e máximo de 11):', 4));
            if (isNaN(numeroplayersPorTime) || numeroplayersPorTime < 4 || numeroplayersPorTime > 11) {
                alert('O número de jogadores por time deve ser entre 4 e 11.');
                return false;
            }
            if (goleirosSelecionados.length < 2) {
                alert('Por favor, selecione pelo menos 2 goleiros para garantir uma distribuição adequada dos jogadores entre os times principais.');
                return false;
            }
            if (confirmados.length < 2 * numeroplayersPorTime) {
                alert('Não há jogadores suficientes para formar pelo menos 2 times completos com a quantidade de jogadores definida por time.');
                return false;
            }
            $.ajax({
                url: '_php/_events/processar_evento.php',
                method: 'POST',
                data: JSON.stringify({
                    confirmados: confirmados,
                    numeroplayersPorTime: numeroplayersPorTime
                }),
                contentType: 'application/json',
                success: function(response) {
                    times = response;
                    exibirTimesSorteados(times);
                    $('#etapa2').hide();
                    $('#etapa3').show();
                },
                error: function(xhr, status, error) {
                    console.error('Erro ao processar evento:', status, error);
                }
            });
        }

        function exibirTimesSorteados(times) {
            var container = $('#timesSorteados');
            container.empty();
            if (times.principais && times.principais.length > 0) {
                var principaisHtml = '<h2 class="mb-4" style="color:#0d6efd">Times Principais</h2>';
                times.principais.forEach((time, index) => {
                    var totalNiveis = 0;
                    var jogadoresHtml = '<ul class="list-group mb-4">';
                    time.jogadores.forEach((jogador) => {
                        jogadoresHtml += '<li class="list-group-item">' + jogador.name_player + ' (' + jogador.position_player + ') - Nível: ' + jogador.level_player + '</li>';
                        totalNiveis += jogador.level_player;
                    });
                    jogadoresHtml += '</ul>';
                    principaisHtml += '<div><h4 class="mb-4">Time ' + (index + 1) + ' - Nível Total: ' + totalNiveis + '</h4>' + jogadoresHtml + '</div>';
                });
                container.append(principaisHtml);
            }
            if (times.reservas && times.reservas.length > 0) {
                var reservasHtml = '<h2 class="mb-2" style="color:#0d6efd">Times Reservas</h2>';
                times.reservas.forEach((time, index) => {
                    var totalNiveis = 0;
                    var jogadoresHtml = '<ul class="list-group mb-4">';
                    time.jogadores.forEach((jogador) => {
                        jogadoresHtml += '<li class="list-group-item">' + jogador.name_player + ' (' + jogador.position_player + ') - Nível: ' + jogador.level_player + '</li>';
                        totalNiveis += jogador.level_player;
                    });
                    jogadoresHtml += '</ul>';
                    reservasHtml += '<div><h4 class="mb-4">Time ' + (index + 1) + ' - Nível Total: ' + totalNiveis + '</h4>' + jogadoresHtml + '</div>';
                });
                container.append(reservasHtml);
            }
        }

        $('#btnEtapa2').click(function() {
            sortearTimes();
        });

        $('#btnVoltarEtapa3').click(function() {
            $('#etapa3').hide();
            $('#etapa2').show();
        });

        $('#salvarEventoBtn').click(function() {
            var nomeEvento = $('#nomeEvento').val().trim();
            var localEvento = $('#localEvento').val();
            var dataEvento = $('#dataEvento').val();
            var jogadoresConfirmados = [];
            $('.confirmar-presenca:checked').each(function() {
                jogadoresConfirmados.push($(this).data('index'));
            });
            if (!times || times.length === 0) {
                alert('Nenhum time foi sorteado. Por favor, sorteie os times antes de salvar o evento.');
                return;
            }
            $.ajax({
                url: '_php/_events/save_event.php',
                method: 'POST',
                data: JSON.stringify({
                    nomeEvento: nomeEvento,
                    localEvento: localEvento,
                    dataEvento: dataEvento,
                    timesSorteados: times
                }),
                contentType: 'application/json',
                success: function(response) {
                    alert('Evento salvo com sucesso!');
                    $('#addeventModal').modal('hide');
                    listEvents(1);
                },
                error: function(xhr, status, error) {
                    console.error('Erro ao salvar evento:', status, error);
                }
            });
        });

        $('#sortearNovamenteBtn').click(function() {
            sortearTimes();
        });
        
        $('#selectAll').change(function() {
            var checked = $(this).prop('checked');
            $('.confirmar-presenca').prop('checked', checked);
        });

        $('#playersTable').on('click', 'tbody tr', function(e) {
            if (!$(e.target).is(':checkbox')) {
                var checkbox = $(this).find('.confirmar-presenca');
                checkbox.prop('checked', !checkbox.prop('checked'));
            }
        });

        var currentPage = 1;
        var pageSize = 10;

        listEvents(currentPage);

        function listEvents(page) {
            var EventName = $('#search-name').val().trim();
            var data = {
                page: page,
                pageSize: pageSize
            };

            if (EventName !== '') {
                data.name = EventName;
            }

            $.ajax({
                url: '_php/_events/list-event-pagination.php',
                method: 'GET',
                dataType: 'json',
                data: data,
                success: function(response) {
                    $('#events-table tbody').empty();
                    $.each(response.events, function(index, event) {
                        var row = '<tr>' +
                        '<td><input type="checkbox" class="form-check-input" value="' + event.id_event + '"></td>' +
                        '<td>' + event.id_event + '</td>' +
                        '<td>' + event.name_event + '</td>' +
                        '<td>' + event.date_event + '</td>' +
                        '<td><a class="view-event page-link" href="#" data-id="' + event.id_event + '"><img src="_assets/_images/view.png" width="24"></a></td>' +
                        '<td><a class="delete-event page-link" href="#" data-id="' + event.id_event + '"><img src="_assets/_images/delete.png" width="24"></a></td>' +
                        '</tr>';
                        $('#events-table tbody').append(row);
                    });
                    $('#massDeleteBtn').hide();
                    updatePagination(response.totalPages, page);
                },
                error: function(err) {
                    console.error('Erro na requisição: ', err);
                }
            });
        }

        $('#events-table').on('change', 'input[type="checkbox"]', function() {
            var checkedCount = $('#events-table tbody input[type="checkbox"]:checked').length;
            if (checkedCount > 0) {
                $('#massDeleteBtn').show();
            } else {
                $('#massDeleteBtn').hide();
            }
        });

        $('#massDeleteBtn').click(function() {
            var eventIds = [];
            $('#events-table tbody input[type="checkbox"]:checked').each(function() {
                eventIds.push($(this).val());
            });
            if (eventIds.length === 0) {
                return;
            }
            if (confirm("Tem certeza que deseja excluir os jogadores selecionados?")) {
                $.ajax({
                    url: '_php/_events/delete-events.php',
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        ids: eventIds
                    },
                    success: function(response) {
                        if (response.success) {
                            listEvents(currentPage);
                        } else {
                            alert('Erro ao remover jogadores.');
                        }
                    },
                    error: function(err) {
                        console.error('Erro ao remover jogadores: ', err);
                    }
                });
            }
        });

        function updatePagination(totalPages, currentPage) {
            var pagination = $('.pagination');
            pagination.empty();
            var prevDisabled = currentPage === 1 ? 'disabled' : '';
            var nextDisabled = currentPage === totalPages ? 'disabled' : '';
            var prevButton = '<li class="page-item ' + prevDisabled + '"><a class="page-link" href="#" data-page="' + (currentPage - 1) + '">Anterior</a></li>';
            pagination.append(prevButton);
            for (var i = 1; i <= totalPages; i++) {
                var activeClass = currentPage === i ? 'active' : '';
                var pageButton = '<li class="page-item ' + activeClass + '"><a class="page-link" href="#" data-page="' + i + '">' + i + '</a></li>';
                pagination.append(pageButton);
            }
            var nextButton = '<li class="page-item ' + nextDisabled + '"><a class="page-link" href="#" data-page="' + (currentPage + 1) + '">Próximo</a></li>';
            pagination.append(nextButton);
        }

        $('.pagination').on('click', '.page-link', function(e) {
            e.preventDefault();
            var page = $(this).data('page');
            listEvents(page);
        });

        $('#clear-search').click(function() {
            $('#search-name').val('');
            listEvents(1);
            $('#clear-search').hide();
        });

        $('#search-name').keypress(function(e) {
            if (e.which === 13) {
                listEvents(1);
                $('#clear-search').show();
            }
        });

        $('#search-button').click(function() {
            var EventName = $('#search-name').val().trim();
            if (EventName !== '') {
                listEvents(1);
                $('#clear-search').show();
            } else {
                alert("Digite o nome da localização.");
            }
        });

        $('#addeventModal').on('hidden.bs.modal', function () {
            $('#eventoForm')[0].reset(); 
        });

        $('#events-table').on('click', '.delete-event', function(e) {
            e.preventDefault();
            var eventId = $(this).data('id');
            if (confirm("Tem certeza que deseja remover este local?")) {
                $.ajax({
                    url: '_php/_events/delete-event.php',
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        eventId: eventId
                    },
                    success: function(response) {
                        listEvents(currentPage);
                    },
                    error: function(err) {
                        console.error('Erro ao remover local: ', err);
                    }
                });
            }
        });

        function atualizarLocais() {
            $.ajax({
            url: '_php/_locations/list-location-pagination.php?page=1&pageSize=1000', // Caminho para o seu endpoint PHP
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                var select = $('#localEvento');
                select.empty();
                response  = response.locations;
                $(response).each((i)=>{
                    select.append('<option value="' + response[i].id_location + '">' + response[i].name_location + '</option>');
                });
            },
            error: function(xhr, status, error) {
                console.error('Erro ao buscar locais:', status, error);
            }
        });
        }
        atualizarLocais();

        $('#events-table').on('click', '.view-event', function(e) {
            var eventId = $(this).data('id');
            $.ajax({
                url: '_php/_events/get-event.php',
                method: 'GET',
                data: { eventId: eventId },
                success: function(response) {
                    if (response) {                      
                        $('#nomeEventoView').val(response.name_event);
                        $('#localEventoView').val(response.name_location);
                        $('#dataEventoView').val(response.date_event);
                        var timesContainer = $('#timesSorteadosView');
                        timesContainer.empty();
                        if (response.teams) {
                            response.teams.forEach(function(team) {
                                timesContainer.append('<h4>' + team.name_team + ' (Nível: ' + team.level_team + ')</h4>');
                                var playersHtml = '<ul>';
                                team.players.forEach(function(player) {
                                    playersHtml += '<li>' + player.name_player + ' (Nível: ' + player.level_player + ')</li>';
                                });
                                playersHtml += '</ul>';
                                timesContainer.append(playersHtml);
                            });
                        }
                        $('#vieweventModal').modal('show');
                    } else {
                        alert('Erro ao buscar os dados do evento.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Erro ao buscar os dados do evento:', status, error);
                }
            });
        });
    });
</script>
<?php require_once("footer.php"); ?>