<?php require_once("header.php"); ?>
<section>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Jogadores</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addPlayerModal">Cadastrar</button>
            </div>
        </div>
    </div>
    <div class="input-group mb-3" style="max-width: 300px;">
        <input type="text" class="form-control" placeholder="Pesquisar por nome" id="search-name" aria-label="Pesquisar por nome" aria-describedby="button-addon2">
        <button class="btn btn-primary" type="button" id="search-button">Buscar</button>
        <button class="btn btn-secondary" type="button" id="clear-search" style="display: none;">Limpar Filtro</button>
    </div>
    <div class="table-responsive small">
        <table class="table table-striped table-sm" id="players-table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Id</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Posição</th>
                    <th scope="col">Nível</th>
                    <th scope="col">Idade</th>
                    <th scope="col">Editar</th>
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
<div class="modal fade" id="addPlayerModal" tabindex="-1" aria-labelledby="addPlayerModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPlayerModalLabel">Cadastrar Jogador</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="playerForm">
                    <div class="mb-3">
                        <label for="playerName" class="form-label">Nome do Jogador</label>
                        <input type="text" class="form-control" id="playerName" name="playerName" maxlength="60" required>
                        <div id="playerNameHelp" class="form-text">Máximo de 60 caracteres.</div>
                    </div>
                    <div class="mb-3">
                        <label for="playerPosition" class="form-label">Posição</label>
                        <select class="form-select" id="playerPosition" name="playerPosition" required>
                            <option value="ATA" selected>Atacante (ATA)</option>
                            <option value="MEI">Meio-campista (MEI)</option>
                            <option value="DEF">Defensor (DEF)</option>
                            <option value="GOL">Goleiro (GOL)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="playerLevel" class="form-label">Nível</label>
                        <input type="number" class="form-control" id="playerLevel" name="playerLevel" min="1" max="5" required>
                        <div id="playerLevelHelp" class="form-text">Mínimo 1 e Máximo 5</div>
                    </div>
                    <div class="mb-3">
                        <label for="playerAge" class="form-label">Idade</label>
                        <input type="number" class="form-control" id="playerAge" name="playerAge" min="0" max="99" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="editPlayerModal" tabindex="-1" aria-labelledby="editPlayerModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPlayerModalLabel">Editar Jogador</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editPlayerForm">
                    <input type="hidden" id="editPlayerId" name="editPlayerId">
                    <div class="mb-3">
                        <label for="editPlayerName" class="form-label">Nome do Jogador</label>
                        <input type="text" class="form-control" id="editPlayerName" name="editPlayerName" maxlength="60" required>
                        <div id="editPlayerNameHelp" class="form-text">Máximo de 60 caracteres.</div>
                    </div>
                    <div class="mb-3">
                        <label for="editPlayerPosition" class="form-label">Posição</label>
                        <select class="form-select" id="editPlayerPosition" name="editPlayerPosition" required>
                            <option value="ATA">Atacante (ATA)</option>
                            <option value="MEI">Meio-campista (MEI)</option>
                            <option value="DEF">Defensor (DEF)</option>
                            <option value="GOL">Goleiro (GOL)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editPlayerLevel" class="form-label">Nível</label>
                        <input type="number" class="form-control" id="editPlayerLevel" name="editPlayerLevel" min="1" max="5" required>
                        <div id="editPlayerLevelHelp" class="form-text">Mínimo 1 e Máximo 5</div>
                    </div>
                    <div class="mb-3">
                        <label for="editPlayerAge" class="form-label">Idade</label>
                        <input type="number" class="form-control" id="editPlayerAge" name="editPlayerAge" min="0" max="99" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        var currentPage = 1;
        var pageSize = 10;
    
        listPlayers(currentPage);
    
        function listPlayers(page) {
            var playerName = $('#search-name').val().trim();
            var data = {
                page: page,
                pageSize: pageSize
            };
            
            if (playerName !== '') {
                data.name = playerName;
            }
            
            $.ajax({
                url: '_php/_player/list-players-pagination.php',
                method: 'GET',
                dataType: 'json',
                data: data,
                success: function(response) {
                    $('#players-table tbody').empty();
                    $.each(response.players, function(index, player) {
                        var row = '<tr>' +
                            '<td><input type="checkbox" class="form-check-input" value="' + player.id_player + '"></td>' + // Corrigido aqui
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
                    $('#massDeleteBtn').hide();
                    updatePagination(response.totalPages, page);
                },
                error: function(err) {
                    console.error('Erro na requisição: ', err);
                }
            });
        }
    
        $('#players-table').on('change', 'input[type="checkbox"]', function() {
            var checkedCount = $('#players-table tbody input[type="checkbox"]:checked').length;
            if (checkedCount > 0) {
                $('#massDeleteBtn').show();
            } else {
                $('#massDeleteBtn').hide();
            }
        });
    
        $('#massDeleteBtn').click(function() {
            var playerIds = [];
            $('#players-table tbody input[type="checkbox"]:checked').each(function() {
                playerIds.push($(this).val());
            });
    
            if (playerIds.length === 0) {
                return;
            }
    
            if (confirm("Tem certeza que deseja remover os jogadores selecionados?")) {
                $.ajax({
                    url: '_php/_player/delete-players.php',
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        ids: playerIds
                    },
                    success: function(response) {
                        if (response.success) {
                            listPlayers(currentPage);
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
            listPlayers(page);
        });
    
        $('#clear-search').click(function() {
            $('#search-name').val('');
            listPlayers(1);
            $('#clear-search').hide();
        });
    
        $('#search-name').keypress(function(e) {
            if (e.which === 13) {
                listPlayers(1);
                $('#clear-search').show();
            }
        });
    
        $('#search-button').click(function() {
            var playerName = $('#search-name').val().trim();
            if (playerName !== '') {
                listPlayers(1);
                $('#clear-search').show();
            } else {
                alert("Digite o nome do jogador.");
            }
        });
    
        $('#addPlayerModal').on('hidden.bs.modal', function () {
            $('#playerForm')[0].reset();
        });
    
        $('#playerForm').submit(function(e) {
            e.preventDefault();
            var playerName = $('#playerName').val();
            var playerPosition = $('#playerPosition').val();
            var playerLevel = $('#playerLevel').val();
            var playerAge = $('#playerAge').val();
            $.ajax({
                url: '_php/_player/add-player.php',
                method: 'POST',
                dataType: 'json',
                data: {
                    playerName: playerName,
                    playerPosition: playerPosition,
                    playerLevel: playerLevel,
                    playerAge: playerAge
                },
                success: function(response) {
                    $("#addPlayerModal").modal('hide');
                    listPlayers(1);
                },
                error: function(err) {
                    console.error('Erro ao cadastrar jogador: ', err);
                }
            });
        });
    
        $('#players-table').on('click', '.delete-player', function(e) {
            e.preventDefault();
            var playerId = $(this).data('id');
            if (confirm("Tem certeza que deseja remover este jogador?")) {
                $.ajax({
                    url: '_php/_player/delete-player.php',
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        playerId: playerId
                    },
                    success: function(response) {
                        listPlayers(currentPage);
                    },
                    error: function(err) {
                        console.error('Erro ao remover jogador: ', err);
                    }
                });
            }
        });
    
        $('#players-table').on('click', '.edit-player', function(e) {
            e.preventDefault();
            var playerId = $(this).data('id');
            $.ajax({
                url: '_php/_player/get-player.php',
                method: 'GET',
                dataType: 'json',
                data: {
                    playerId: playerId
                },
                success: function(response) {
                    $('#editPlayerId').val(response.id_player);
                    $('#editPlayerName').val(response.name_player);
                    $('#editPlayerPosition').val(response.position_player);
                    $('#editPlayerLevel').val(response.level_player);
                    $('#editPlayerAge').val(response.age_player);
                    $('#editPlayerModal').modal('show');
                },
                error: function(err) {
                    console.error('Erro ao carregar dados do jogador: ', err);
                }
            });
        });
    
        $('#editPlayerForm').submit(function(e) {
            e.preventDefault();
            var playerId = $('#editPlayerId').val();
            var playerName = $('#editPlayerName').val();
            var playerPosition = $('#editPlayerPosition').val();
            var playerLevel = $('#editPlayerLevel').val();
            var playerAge = $('#editPlayerAge').val();
            $.ajax({
                url: '_php/_player/update-player.php',
                method: 'POST',
                dataType: 'json',
                data: {
                    playerId: playerId,
                    playerName: playerName,
                    playerPosition: playerPosition,
                    playerLevel: playerLevel,
                    playerAge: playerAge
                },
                success: function(response) {
                    $('#editPlayerModal').modal('hide');
                    listPlayers(currentPage);
                },
                error: function(err) {
                    console.error('Erro ao atualizar jogador: ', err);
                }
            });
        });
    });
</script>
<?php require_once("footer.php"); ?>