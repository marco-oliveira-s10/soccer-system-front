$(document).ready(function () {
    
    var currentPage = 1;
    var pageSize = 10;

    listEvents(currentPage);

    function listEvents(page) {
        $.ajax({
            url: 'https://soccer-system.azurewebsites.net/api/events',
            method: 'GET',
            dataType: 'json',
            data: {
                page: page,
                perPage: pageSize
            },
            success: function (response) {
                $('#events-table tbody').empty();

                if (response.data && response.data.length > 0) {
                    $.each(response.data, function (index, event) {
                        var row = '<tr>' +
                        '<td><input type="checkbox" class="form-check-input" value="' + event.id_event + '"></td>' +
                        '<td>' + event.id_event + '</td>' +
                        '<td>' + event.name_event + '</td>' +
                        '<td>' + event.location.location_location + '</td>' +
                        '<td>' + event.date_event + '</td>' +
                        '<td><a class="view-event page-link" href="#" data-id="' + event.id_event + '"><img src="_assets/_images/view.png" width="25"></a></td>' +
                        '<td><a class="delete-event page-link" href="#" data-id="' + event.id_event + '"><img src="_assets/_images/delete.png" width="24"></a></td>' +
                        '</tr>';
                        $('#events-table tbody').append(row);
                    });

                    updatePaginationEvent(response.last_page, page);
                } else {
                    $('#events-table tbody').append('<tr><td colspan="7">Nenhum evento encontrado</td></tr>');
                }
            },
            error: function (err) {
                console.error('Erro na requisição: ', err);
            }
        });
    }

    function listByNameEvents(page, name) {
        $.ajax({
            url: 'https://soccer-system.azurewebsites.net/api/events/filter?name=' + name,
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                $('#events-table tbody').empty();

                if (response.data && response.data.length > 0) {
                    $.each(response.data, function (index, event) {
                        var row = '<tr>' +
                        '<td><input type="checkbox" class="form-check-input" value="' + event.id_event + '"></td>' +
                        '<td>' + event.id_event + '</td>' +
                        '<td>' + event.name_event + '</td>' +
                        '<td>' + event.location.location_location + '</td>' +
                        '<td>' + event.date_event + '</td>' +
                        '<td><a class="edit-event page-link" href="#" data-id="' + event.id_event + '"><img src="_assets/_images/edit.png" width="25"></a></td>' +
                        '<td><a class="delete-event page-link" href="#" data-id="' + event.id_event + '"><img src="_assets/_images/delete.png" width="24"></a></td>' +
                        '</tr>';
                        $('#events-table tbody').append(row);
                    });

                    updatePaginationEvent(response.last_page, page);
                } else {
                    $('#events-table tbody').append('<tr><td colspan="7">Nenhum evento encontrado</td></tr>');
                }
            },
            error: function (err) {
                console.error('Erro na requisição: ', err);
            }
        });
    }

    function updatePaginationEvent(totalPages, currentPage) {
        var pagination = $('.paginationEvents');
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

    $('.paginationEvents').on('click', '.page-link', function (e) {
        e.preventDefault();
        var page = $(this).data('page');
        if (page) {
            currentPage = page;  // Atualize a página atual
            listEvents(page);
        }
    });

    $('#clear-search').click(function () {
        $('#search-name-event').val('');
        listEvents(1);
        $('#clear-search').hide();
    });

    $('#search-name-event').keypress(function (e) {
        if (e.which === 13) {
            var eventName = $('#search-name-event').val().trim();
            if (eventName !== '') {
                listByNameEvents(1, eventName);
                $('#clear-search').show();
            } else {
                listEvents(1);
                $('#clear-search').hide();
            }
        }
    });

    $('#search-button-event').click(function () {
        var eventName = $('#search-name-event').val().trim();
        if (eventName !== '') {
            listByNameEvents(1, eventName);
            $('#clear-search').show();
        } else {
            alert("Digite o nome do evento.");
        }
    });

    $('#addeventModal').on('hidden.bs.modal', function () {
        location.reload();
    });

    $('#events-table').on('click', '.delete-event', function (e) {
        e.preventDefault();
        var eventId = $(this).data('id');
        
        if (confirm("Tem certeza que deseja remover este evento?")) {
            $.ajax({
                url: 'https://soccer-system.azurewebsites.net/api/events/' + eventId,
                method: 'DELETE',
                dataType: 'json',                
                success: function (response) {
                    alert("Registro removido com sucesso!");
                    listEvents(currentPage);
                },
                error: function (err) {
                    console.error('Erro ao remover evento: ', err);
                }
            });
        }
    });

    $('#events-table').on('change', 'input[type="checkbox"]', function () {
        var checkedCount = $('#events-table tbody input[type="checkbox"]:checked').length;
        if (checkedCount > 0) {
            $('#massDeleteBtnEvents').show();
        } else {
            $('#massDeleteBtnEvents').hide();
        }
    });

    $('#massDeleteBtnEvents').click(function () {
        var eventsIds = [];
        $('#events-table tbody input[type="checkbox"]:checked').each(function () {
            eventsIds.push($(this).val());
        });

        if (eventsIds.length === 0) {
            alert("Nenhum eventos selecionada.");
            return;
        }

        if (confirm("Tem certeza que deseja excluir os eventos selecionados?")) {
            var deletePromises = eventsIds.map(function (id) {
                return $.ajax({
                    url: 'https://soccer-system.azurewebsites.net/api/events/' + id,
                    method: 'DELETE',
                    dataType: 'json'
                });
            });

            $.when.apply($, deletePromises).done(function () {
                alert("Eventos removidos com sucesso!");
                $('#massDeleteBtnEvents').hide();
                listEvents(currentPage);
            }).fail(function (err) {
                console.error('Erro ao remover eventos: ', err);
            });
        }
    });

    $('#events-table').on('click', '.view-event', function (e) {
        e.preventDefault();

        var eventId = $(this).data('id');

        if (!eventId) {
            alert('ID do evento inválido.');
            return;
        }

        $.ajax({
            url: 'https://soccer-system.azurewebsites.net/api/events/' + eventId,
            method: 'GET',
            success: function (response) {
                if (response) {
                    $('#nomeEventoView').val(response.name_event || 'N/A');
                    $('#localEventoView').val(response.location ? response.location.name_location : 'N/A');
                    $('#dataEventoView').val(response.date_event || 'N/A');

                    var timesContainer = $('#timesSorteadosView');
                    timesContainer.empty();

                    if (response.teams && Array.isArray(response.teams)) {
                        response.teams.forEach(function (team) {
                            timesContainer.append('<h4>' + (team.name_team || 'Nome não disponível') + ' (Nível: ' + (team.level_team || 'N/A') + ')</h4>');
                            var playersHtml = '<ul>';
                            if (team.players && Array.isArray(team.players)) {
                                team.players.forEach(function (player) {
                                    playersHtml += '<li>' + (player.name_player || 'Nome não disponível') + ' (Nível: ' + (player.level_player || 'N/A') + ') - ' + (player.position_player || 'N/A') +'</li>';
                                });
                            } else {
                                playersHtml += '<li>Nenhum jogador encontrado.</li>';
                            }
                            playersHtml += '</ul>';
                            timesContainer.append(playersHtml);
                        });
                    } else {
                        timesContainer.append('<p>Nenhuma equipe encontrada.</p>');
                    }

                    $('#vieweventModal').modal('show');
                } else {
                    alert('Dados do evento não encontrados.');
                }
            },
            error: function (xhr, status, error) {
                console.error('Erro ao buscar os dados do evento:', status, error);
                alert('Erro ao buscar os dados do evento. Por favor, tente novamente mais tarde.');
            }
        });
    });

    var players = [];
    var times = [];

    function atualizarLocais() {
        $.ajax({
            url: 'https://soccer-system.azurewebsites.net/api/locations?page=1&perPage=999',
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                var select = $('#localEvento');
                select.empty();
                var locations = response.data;
                $(locations).each(function (i, location) {
                    select.append('<option value="' + location.id_location + '">' + location.name_location + '</option>');
                });
            },
            error: function (xhr, status, error) {
                console.error('Erro ao buscar locais:', status, error);
            }
        });
    }

    atualizarLocais();

    $('#btnEtapa1').click(function () {
        var nomeEvento = $('#nomeEvento').val().trim();
        var localEvento = $('#localEvento').val();
        var dataEvento = $('#dataEvento').val();
        if (!nomeEvento || !localEvento || !dataEvento) {
            alert('Todos os campos da Etapa 1 são obrigatórios.');
            return;
        }
        $('#etapa1').hide();
        $('#etapa2').show();
    });

    $('#btnVoltarEtapa2').click(function () {
        $('#etapa2').hide();
        $('#etapa1').show();
    });

    $('#btnEtapa2').click(function () {
        sortearTimes();
    });

    $('#btnVoltarEtapa3').click(function () {
        $('#etapa3').hide();
        $('#etapa2').show();
    });

    function buscarPlayers() {
        $.ajax({
            url: 'https://soccer-system.azurewebsites.net/api/players?page=1&perPage=999',
            method: 'GET',
            success: function(response) {
                var tabela = $('#playersTable tbody');
                tabela.empty();
                players = response.data || [];
                players.forEach((player) => {
                    var row = '<tr data-index="' + player.id_player + '">' +
                    '<td><input type="checkbox" class="confirmar-presenca" data-index="' + player.id_player + '"></td>' +
                    '<td>' + player.name_player + '</td>' +
                    '<td>' + player.position_player + '</td>' +
                    '<td>' + player.level_player + '</td>' +
                    '</tr>';
                    tabela.append(row);
                });
            },
            error: function(xhr, status, error) {
                console.error('Erro ao buscar players:', status, error);
            }
        });
    }

    buscarPlayers();

    $('#selectAll').change(function () {
        var checked = $(this).prop('checked');
        $('.confirmar-presenca').prop('checked', checked);
    });

    $('#playersTable').on('click', 'tbody tr', function (e) {
        if (!$(e.target).is(':checkbox')) {
            var checkbox = $(this).find('.confirmar-presenca');
            checkbox.prop('checked', !checkbox.prop('checked'));
        }
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

        let payload = JSON.stringify({
            confirmados: confirmados,
            numeroplayersPorTime: numeroplayersPorTime
        });

        $.ajax({
            url: 'https://soccer-system.azurewebsites.net/api/player-draw',
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
                    jogadoresHtml += '<li class="list-group-item" data-id="' + jogador.id_player + '">' + jogador.name_player + ' (' + jogador.position_player + ') - Nível: ' + jogador.level_player + '</li>';
                    totalNiveis += jogador.level_player;
                });
                jogadoresHtml += '</ul>';
                principaisHtml += '<div><h4 class="mb-4">Time ' + (index + 1) + ' - Nível Total: ' + totalNiveis + '</h4>' + jogadoresHtml + '</div>';
            });
            container.append(principaisHtml);
        }
        if (times.reservas && times.reservas.length > 0) {
            var reservasHtml = '<h2 class="mb-2" style="color:#0d6efd">Reservas</h2>';
            times.reservas.forEach((time, index) => {
                var totalNiveis = 0;
                var jogadoresHtml = '<ul class="list-group mb-4">';
                time.jogadores.forEach((jogador) => {
                    jogadoresHtml += '<li class="list-group-item" data-id="' + jogador.id_player + '">' + jogador.name_player + ' (' + jogador.position_player + ') - Nível: ' + jogador.level_player + '</li>';
                    totalNiveis += jogador.level_player;
                });
                jogadoresHtml += '</ul>';
                reservasHtml += '<div><h4 class="mb-4">Time ' + (index + 1) + ' Reserva - Nível Total: ' + totalNiveis + '</h4>' + jogadoresHtml + '</div>';
            });
            container.append(reservasHtml);
        }
    }

    $('#sortearNovamenteBtn').click(function () {
        sortearTimes();
    });

    function getTimesFromUI() {
        var times = { principais: [], reservas: [] };

        $('#timesSorteados h2').each(function(index, element) {
            var isPrincipal = $(element).text().includes('Times Principais');
            var timeArray = isPrincipal ? times.principais : times.reservas;
            var timeElements = $(element).nextUntil('h2');

            timeElements.each(function() {
                var h4Element = $(this).find('h4');
                if (h4Element.length) {
                    var teamName = h4Element.text().split(' - ')[0];
                    var players = [];
                    var totalLevel = 0;

                    $(this).find('ul.list-group li').each(function() {
                        var jogadorText = $(this).text();
                        var playerId = $(this).data('id');

                        var playerName = jogadorText.split(' (')[0];
                        var playerLevel = parseInt(jogadorText.split('Nível: ')[1]);

                        players.push(playerId);
                        totalLevel += playerLevel;
                    });

                    timeArray.push({
                        name_team: teamName,
                        level_team: totalLevel,
                        players: players
                    });
                }
            });
        });

        return times;
    }

    $('#salvarEventoBtn').click(function() {
        var name_event = $('#nomeEvento').val().trim();
        var id_location = $('#localEvento').val();
        var date_event = $('#dataEvento').val();
        var times = getTimesFromUI();

        if (!times.principais.length && !times.reservas.length) {
            alert('Nenhum time foi sorteado. Por favor, sorteie os times antes de salvar o evento.');
            return;
        }

        var payload = {
            name_event: name_event,
            id_location: id_location,
            date_event: date_event,
            teams: times.principais.concat(times.reservas)
        };

        $.ajax({
            url: 'https://soccer-system.azurewebsites.net/api/events',
            method: 'POST',
            data: JSON.stringify(payload),
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
});