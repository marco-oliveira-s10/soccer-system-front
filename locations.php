<?php require_once("header.php"); ?>
<section>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Locais</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addlocationModal">Cadastrar</button>
            </div>
        </div>
    </div>
    <div class="input-group mb-3" style="max-width: 300px;">
        <input type="text" class="form-control" placeholder="Pesquisar por nome" id="search-name" aria-label="Pesquisar por nome" aria-describedby="button-addon2">
        <button class="btn btn-primary" type="button" id="search-button">Buscar</button>
        <button class="btn btn-secondary" type="button" id="clear-search" style="display: none;">Limpar Filtro</button>
    </div>
    <div class="table-responsive small">
        <table class="table table-striped table-sm" id="locations-table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Id</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Localização</th>
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

<!-- Modal de Cadastro -->
<div class="modal fade" id="addlocationModal" tabindex="-1" aria-labelledby="addlocationModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addlocationModalLabel">Cadastrar Local</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="locationForm">
                    <div class="mb-3">
                        <label for="locationName" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="locationName" name="locationName" maxlength="60" required>
                        <div id="locationNameHelp" class="form-text">Máximo de 60 caracteres.</div>
                    </div>
                    <div class="mb-3">
                        <label for="locationLocationName" class="form-label">Nome do Local</label>
                        <input type="text" class="form-control" id="locationLocationName" name="locationLocationName" maxlength="60" required>
                        <div id="locationLocationNameHelp" class="form-text">Máximo de 60 caracteres.</div>
                    </div>
                    <div id="formError" class="text-danger" style="display: none;">Todos os campos são obrigatórios.</div>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Edição -->
<div class="modal fade" id="editlocationModal" tabindex="-1" aria-labelledby="editlocationModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editlocationModalLabel">Editar Local</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editlocationForm">
                    <input type="hidden" id="editlocationId" name="editlocationId">
                    <div class="mb-3">
                        <label for="editlocationName" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="editlocationName" name="editlocationName" maxlength="60" required>
                        <div id="editlocationNameHelp" class="form-text">Máximo de 60 caracteres.</div>
                    </div>
                    <div class="mb-3">
                        <label for="editlocationLocationName" class="form-label">Nome do Local</label>
                        <input type="text" class="form-control" id="editlocationLocationName" name="editlocationLocationName" maxlength="60" required>
                        <div id="editlocationLocationNameHelp" class="form-text">Máximo de 60 caracteres.</div>
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
    
        listLocations(currentPage);
    
        function listLocations(page) {
            var locationName = $('#search-name').val().trim();
            var data = {
                page: page,
                pageSize: pageSize
            };
            
            if (locationName !== '') {
                data.name = locationName;
            }
            
            $.ajax({
                url: '_php/_locations/list-location-pagination.php',
                method: 'GET',
                dataType: 'json',
                data: data,
                success: function(response) {
                    $('#locations-table tbody').empty();
                    $.each(response.locations, function(index, location) {
                        var row = '<tr>' +
                            '<td><input type="checkbox" class="form-check-input" value="' + location.id_location + '"></td>' +
                            '<td>' + location.id_location + '</td>' +
                            '<td>' + location.name_location + '</td>' +
                            '<td>' + location.location_location + '</td>' +
                            '<td><a class="edit-location page-link" href="#" data-id="' + location.id_location + '"><img src="_assets/_images/edit.png" width="25"></a></td>' +
                            '<td><a class="delete-location page-link" href="#" data-id="' + location.id_location + '"><img src="_assets/_images/delete.png" width="24"></a></td>' +
                            '</tr>';
                        $('#locations-table tbody').append(row);
                    });
                    $('#massDeleteBtn').hide();
                    updatePagination(response.totalPages, page);
                },
                error: function(err) {
                    console.error('Erro na requisição: ', err);
                }
            });
        }
    
        $('#locations-table').on('change', 'input[type="checkbox"]', function() {
            var checkedCount = $('#locations-table tbody input[type="checkbox"]:checked').length;
            if (checkedCount > 0) {
                $('#massDeleteBtn').show();
            } else {
                $('#massDeleteBtn').hide();
            }
        });
    
        $('#massDeleteBtn').click(function() {
            var locationIds = [];
            $('#locations-table tbody input[type="checkbox"]:checked').each(function() {
                locationIds.push($(this).val());
            });
    
            if (locationIds.length === 0) {
                return;
            }
    
            if (confirm("Tem certeza que deseja remover os jogadores selecionados?")) {
                $.ajax({
                    url: '_php/_locations/delete-locations.php',
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        ids: locationIds
                    },
                    success: function(response) {
                        if (response.success) {
                            listLocations(currentPage);
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
            listLocations(page);
        });
    
        $('#clear-search').click(function() {
            $('#search-name').val('');
            listLocations(1);
            $('#clear-search').hide();
        });
    
        $('#search-name').keypress(function(e) {
            if (e.which === 13) {
                listLocations(1);
                $('#clear-search').show();
            }
        });
    
        $('#search-button').click(function() {
            var locationName = $('#search-name').val().trim();
            if (locationName !== '') {
                listLocations(1);
                $('#clear-search').show();
            } else {
                alert("Digite o nome da localização.");
            }
        });
    
        $('#addlocationModal').on('hidden.bs.modal', function () {
            $('#locationForm')[0].reset();
            $('#formError').hide();
        });
    
        $('#locationForm').submit(function(e) {
            e.preventDefault();
            var locationName = $('#locationName').val().trim();
            var locationLocationName = $('#locationLocationName').val().trim();
    
            if (locationName === '' || locationLocationName === '') {
                $('#formError').show();
                return;
            }
    
            $.ajax({
                url: '_php/_locations/add-location.php',
                method: 'POST',
                dataType: 'json',
                data: {
                    locationName: locationName,
                    locationLocationName: locationLocationName
                },
                success: function(response) {
                    $("#addlocationModal").modal('hide');
                    listLocations(1);
                },
                error: function(err) {
                    console.error('Erro ao cadastrar local: ', err);
                }
            });
        });
    
        $('#locations-table').on('click', '.delete-location', function(e) {
            e.preventDefault();
            var locationId = $(this).data('id');
            if (confirm("Tem certeza que deseja remover este local?")) {
                $.ajax({
                    url: '_php/_locations/delete-location.php',
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        locationId: locationId
                    },
                    success: function(response) {
                        listLocations(currentPage);
                    },
                    error: function(err) {
                        console.error('Erro ao remover local: ', err);
                    }
                });
            }
        });
    
        $('#locations-table').on('click', '.edit-location', function(e) {
            e.preventDefault();
            var locationId = $(this).data('id');
            $.ajax({
                url: '_php/_locations/get-location.php',
                method: 'GET',
                dataType: 'json',
                data: {
                    locationId: locationId
                },
                success: function(response) {
                    $('#editlocationId').val(response.id_location);
                    $('#editlocationName').val(response.name_location);
                    $('#editlocationLocationName').val(response.location_location);
                    $('#editlocationModal').modal('show');
                },
                error: function(err) {
                    console.error('Erro ao carregar dados do local: ', err);
                }
            });
        });
    
        $('#editlocationForm').submit(function(e) {
            e.preventDefault();
            var locationId = $('#editlocationId').val();
            var locationName = $('#editlocationName').val().trim();
            var locationLocationName = $('#editlocationLocationName').val().trim();
    
            if (locationName === '' || locationLocationName === '') {
                alert('Todos os campos são obrigatórios.');
                return;
            }
    
            $.ajax({
                url: '_php/_locations/update-location.php',
                method: 'POST',
                dataType: 'json',
                data: {
                    locationId: locationId,
                    locationName: locationName,
                    locationLocationName: locationLocationName,
                },
                success: function(response) {
                    $('#editlocationModal').modal('hide');
                    listLocations(currentPage);
                },
                error: function(err) {
                    console.error('Erro ao atualizar local: ', err);
                }
            });
        });
    });
</script>
<?php require_once("footer.php"); ?>
