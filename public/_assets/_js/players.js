$(document).ready(function () {

    var currentPage = 1;
    var pageSize = 10;

    listPlayers(currentPage);

    function listPlayers(page) {        
        $.ajax({
            url: 'http://127.0.0.1:8000/api/players',
            method: 'GET',
            dataType: 'json',
            data: {
                page: page,
                perPage: pageSize
            },
            success: function (response) {
                $('#players-table tbody').empty();

                if (response.data && response.data.length > 0) {
                    $.each(response.data, function (index, player) {
                        var row = '<tr>' +
                        '<td><input type="checkbox" class="form-check-input" value="' + player.id_player + '"></td>' +
                        '<td>' + player.id_player + '</td>' +
                        '<td>' + player.name_player + '</td>' +
                        '<td>' + player.position_player + '</td>' +
                        '<td>' + player.level_player + '</td>' +
                        '<td>' + player.age_player + '</td>' +
                        '<td><a class="edit-player page-link" href="#" data-id="' + player.id_player + '"><img src="_assets/_images/edit.png" width="25"></a></td>' +
                        '<td><a class="delete-player page-link" href="#" data-id="' + player.id_player + '"><img src="_assets/_images/delete.png" width="24"></a></td>' +
                        '</tr>';
                        $('#players-table tbody').append(row);
                    });

                    updatePaginationPlayer(response.last_page, page);
                } else {
                    $('#players-table tbody').append('<tr><td colspan="8">Nenhum jogador encontrado</td></tr>');
                }
            },
            error: function (err) {
                console.error('Erro na requisição: ', err);
            }
        });
    }

    function listByNamePlayers(page, name) {        
        $.ajax({
            url: 'http://127.0.0.1:8000/api/players/filter?name=' + name,
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                $('#players-table tbody').empty();

                if (response.data && response.data.length > 0) {
                    $.each(response.data, function (index, player) {
                        var row = '<tr>' +
                        '<td><input type="checkbox" class="form-check-input" value="' + player.id_player + '"></td>' +
                        '<td>' + player.id_player + '</td>' +
                        '<td>' + player.name_player + '</td>' +
                        '<td>' + player.position_player + '</td>' +
                        '<td>' + player.level_player + '</td>' +
                        '<td>' + player.age_player + '</td>' +
                        '<td><a class="edit-player page-link" href="#" data-id="' + player.id_player + '"><img src="_assets/_images/edit.png" width="25"></a></td>' +
                        '<td><a class="delete-player page-link" href="#" data-id="' + player.id_player + '"><img src="_assets/_images/delete.png" width="24"></a></td>' +
                        '</tr>';
                        $('#players-table tbody').append(row);
                    });

                    updatePaginationPlayer(response.last_page, page);
                } else {
                    $('#players-table tbody').append('<tr><td colspan="8">Nenhum jogador encontrado</td></tr>');
                }
            },
            error: function (err) {
                console.error('Erro na requisição: ', err);
            }
        });
    }

    function updatePaginationPlayer(totalPages, currentPage) {
        var pagination = $('.paginationPlayers');
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

    $('.paginationPlayers').on('click', '.page-link', function (e) {
        e.preventDefault();
        var page = $(this).data('page');
        if (page) {
            currentPage = page;
            listPlayers(page);
        }
    });

    $('#clear-search').click(function () {
        $('#search-name-player').val('');
        listPlayers(1);
        $('#clear-search').hide();
    });

    $('#search-name-player').keypress(function (e) {
        if (e.which === 13) {
            var playerName = $('#search-name-player').val().trim();
            if (playerName !== '') {
                listPlayers(1);
                $('#clear-search').show();
            } else {
                listPlayers(1);
                $('#clear-search').hide();
            }
        }
    });

    $('#search-button-player').click(function () {
        var playerName = $('#search-name-player').val().trim();
        if (playerName !== '') {
            listByNamePlayers(1, playerName);
            $('#clear-search').show();
        } else {
            alert("Digite o nome do jogador.");
        }
    });

    $('#addPlayerModal').on('hidden.bs.modal', function () {
        $('#playerForm')[0].reset();
        $('#formError').hide();
    });

    $('#playerForm').submit(function (e) {
        e.preventDefault();
        var playerName = $('#playerName').val().trim();
        var playerPosition = $('#playerPosition').val().trim();
        var playerLevel = $('#playerLevel').val().trim();
        var playerAge = $('#playerAge').val().trim();
        
        if (playerName === '' || playerPosition === '' || playerLevel === '' || playerAge === '') {
            $('#formError').text('Todos os campos são obrigatórios').show();
            return;
        }

        $.ajax({
            url: 'http://127.0.0.1:8000/api/players',
            method: 'POST',
            dataType: 'json',
            data: {
                playerName: playerName,
                playerPosition: playerPosition,
                playerLevel: playerLevel,
                playerAge: playerAge
            },
            success: function (response) {
                alert("Jogador cadastrado com sucesso!");
                $("#addPlayerModal").modal('hide');
                listPlayers(currentPage);
            },
            error: function (xhr) {
                var errors = xhr.responseJSON.errors;
                if (errors) {
                    var errorMessage = Object.values(errors).join(', ');
                    $('#formError').text(errorMessage).show();
                } else {
                    console.error('Erro ao cadastrar jogador: ', xhr);
                    $('#formError').text('Erro desconhecido. Tente novamente.').show();
                }
            }
        });
    });

    $('#players-table').on('click', '.delete-player', function (e) {
        e.preventDefault();
        var playerId = $(this).data('id');
        
        if (confirm("Tem certeza que deseja remover este jogador?")) {
            $.ajax({
                url: 'http://127.0.0.1:8000/api/players/' + playerId,
                method: 'DELETE',
                dataType: 'json',
                success: function (response) {
                    alert("Jogador removido com sucesso!");
                    listPlayers(currentPage);
                },
                error: function (err) {
                    console.error('Erro ao remover jogador: ', err);
                }
            });
        }
    });

    $('#players-table').on('click', '.edit-player', function (e) {
        e.preventDefault();
        var playerId = $(this).data('id');
        
        $.ajax({
            url: 'http://127.0.0.1:8000/api/players/' + playerId,
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                $('#editPlayerId').val(response.id_player);
                $('#editPlayerName').val(response.name_player);
                $('#editPlayerPosition').val(response.position_player);
                $('#editPlayerLevel').val(response.level_player);
                $('#editPlayerAge').val(response.age_player);
                $('#editPlayerModal').modal('show');
            },
            error: function (err) {
                console.error('Erro ao carregar dados do jogador: ', err);
            }
        });
    });

    $('#editPlayerForm').submit(function (e) {
        e.preventDefault();

        var playerId = $('#editPlayerId').val();
        var playerName = $('#editPlayerName').val().trim();
        var playerPosition = $('#editPlayerPosition').val().trim();
        var playerLevel = $('#editPlayerLevel').val().trim();
        var playerAge = $('#editPlayerAge').val().trim();

        if (playerName === '' || playerPosition === '' || playerLevel === '' || playerAge === '') {
            alert('Todos os campos são obrigatórios.');
            return;
        }

        $.ajax({
            url: 'http://127.0.0.1:8000/api/players/' + playerId,
            method: 'PUT',
            dataType: 'json',
            data: {
                playerName: playerName,
                playerPosition: playerPosition,
                playerLevel: playerLevel,
                playerAge: playerAge
            },
            success: function (response) {
                alert("Jogador atualizado com sucesso!");
                $('#editPlayerModal').modal('hide');
                listPlayers(currentPage);
            },
            error: function (err) {
                console.error('Erro ao atualizar jogador: ', err);
            }
        });
    });

    $('#players-table').on('change', 'input[type="checkbox"]', function () {
        var checkedCount = $('#players-table tbody input[type="checkbox"]:checked').length;
        if (checkedCount > 0) {
            $('#massDeleteBtnPlayers').show();
        } else {
            $('#massDeleteBtnPlayers').hide();
        }
    });

    $('#massDeleteBtnPlayers').click(function () {
        var playersIds = [];
        $('#players-table tbody input[type="checkbox"]:checked').each(function () {
            playersIds.push($(this).val());
        });

        if (playersIds.length === 0) {
            alert("Nenhum jogador selecionado.");
            return;
        }

        if (confirm("Tem certeza que deseja excluir os jogadores selecionados?")) {
            var deletePromises = playersIds.map(function (id) {
                return $.ajax({
                    url: 'http://127.0.0.1:8000/api/players/' + id,
                    method: 'DELETE',
                    dataType: 'json'
                });
            });

            $.when.apply($, deletePromises).done(function () {
                alert("Jogadores removidos com sucesso!");
                $('#massDeleteBtnPlayers').hide();
                listPlayers(currentPage);
            }).fail(function (err) {
                console.error('Erro ao remover jogadores: ', err);
            });
        }
    });

});
