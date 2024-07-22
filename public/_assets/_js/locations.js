$(document).ready(function () {
    
    var currentPage = 1;
    var pageSize = 10;

    listLocations(currentPage);

    function listLocations(page) {
        $.ajax({
            url: 'https://soccer-system.azurewebsites.net/api/locations',
            method: 'GET',
            dataType: 'json',
            data: {
                page: page,
                perPage: pageSize
            },
            success: function (response) {
                $('#locations-table tbody').empty();

                if (response.data && response.data.length > 0) {
                    $.each(response.data, function (index, location) {
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

                    updatePaginationLocation(response.last_page, page);
                } else {
                    $('#locations-table tbody').append('<tr><td colspan="6">Nenhuma localização encontrada</td></tr>');
                }
            },
            error: function (err) {
                console.error('Erro na requisição: ', err);
            }
        });
    }

    function listByNameLocations(page, name) {
        $.ajax({
            url: 'https://soccer-system.azurewebsites.net/api/locations/filter?name=' + name,
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                $('#locations-table tbody').empty();

                if (response.data && response.data.length > 0) {
                    $.each(response.data, function (index, location) {
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

                    updatePaginationLocation(response.last_page, page);
                } else {
                    $('#locations-table tbody').append('<tr><td colspan="6">Nenhuma localização encontrada</td></tr>');
                }
            },
            error: function (err) {
                console.error('Erro na requisição: ', err);
            }
        });
    }

    function updatePaginationLocation(totalPages, currentPage) {
        var pagination = $('.paginationLocations');
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

    $('.paginationLocations').on('click', '.page-link', function (e) {
        e.preventDefault();
        var page = $(this).data('page');
        if (page) {
            currentPage = page;  // Atualize a página atual
            listLocations(page);
        }
    });

    $('#clear-search').click(function () {
        $('#search-name-location').val('');
        listLocations(1);
        $('#clear-search').hide();
    });

    $('#search-name-location').keypress(function (e) {
        if (e.which === 13) {
            var locationName = $('#search-name-location').val().trim();
            if (locationName !== '') {
                listByNameLocations(1, locationName);
                $('#clear-search').show();
            } else {
                listLocations(1);
                $('#clear-search').hide();
            }
        }
    });

    $('#search-button-location').click(function () {
        var locationName = $('#search-name-location').val().trim();
        if (locationName !== '') {
            listByNameLocations(1, locationName);
            $('#clear-search').show();
        } else {
            alert("Digite o nome da localização.");
        }
    });

    $('#addlocationModal').on('hidden.bs.modal', function () {
        $('#locationForm')[0].reset();
        $('#formError').hide();
    });

    $('#locationForm').submit(function (e) {
        e.preventDefault();
        var locationName = $('#locationName').val().trim();
        var locationLocationName = $('#locationLocationName').val().trim();
        
        if (locationName === '' || locationLocationName === '') {
            $('#formError').text('Todos os campos são obrigatórios').show();
            return;
        }

        $.ajax({
            url: 'https://soccer-system.azurewebsites.net/api/locations',
            method: 'POST',
            dataType: 'json',
            data: {
                locationName: locationName,
                locationLocationName: locationLocationName
            },
            success: function (response) {
                alert("Cadastrado com sucesso!");
                $("#addlocationModal").modal('hide');
                listLocations(currentPage);
            },
            error: function (xhr) {
                var errors = xhr.responseJSON.errors;
                if (errors) {
                    var errorMessage = Object.values(errors).join(', ');
                    $('#formError').text(errorMessage).show();
                } else {
                    console.error('Erro ao cadastrar local: ', xhr);
                    $('#formError').text('Erro desconhecido. Tente novamente.').show();
                }
            }
        });
    });

    $('#locations-table').on('click', '.delete-location', function (e) {
        e.preventDefault();
        var locationId = $(this).data('id');
        
        if (confirm("Tem certeza que deseja remover este local?")) {
            $.ajax({
                url: 'https://soccer-system.azurewebsites.net/api/locations/' + locationId,
                method: 'DELETE',
                dataType: 'json',                
                success: function (response) {
                    alert("Registro removido com sucesso!");
                    listLocations(currentPage);
                },
                error: function (err) {
                    console.error('Erro ao remover local: ', err);
                }
            });
        }
    });

    $('#locations-table').on('click', '.edit-location', function (e) {
        e.preventDefault();
        var locationId = $(this).data('id');
        
        $.ajax({
            url: 'https://soccer-system.azurewebsites.net/api/locations/' + locationId,
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                $('#editlocationId').val(response.id_location);
                $('#editlocationName').val(response.name_location);
                $('#editlocationLocationName').val(response.location_location);
                $('#editlocationModal').modal('show');
            },
            error: function (err) {
                console.error('Erro ao carregar dados: ', err);
            }
        });
    });

    $('#editlocationForm').submit(function (e) {
        e.preventDefault();

        var locationId = $('#editlocationId').val();
        var locationName = $('#editlocationName').val().trim();
        var locationLocationName = $('#editlocationLocationName').val().trim();

        if (locationName === '' || locationLocationName === '') {
            alert('Todos os campos são obrigatórios.');
            return;
        }

        $.ajax({
            url: 'https://soccer-system.azurewebsites.net/api/locations/' + locationId,
            method: 'PUT',
            dataType: 'json',
            data: {
                locationName: locationName,
                locationLocationName: locationLocationName,
            },
            success: function (response) {
                alert("Registro alterado com sucesso!");
                $('#editlocationModal').modal('hide');
                listLocations(currentPage);
            },
            error: function (err) {
                console.error('Erro ao atualizar local: ', err);
            }
        });
    });

    $('#locations-table').on('change', 'input[type="checkbox"]', function () {
        var checkedCount = $('#locations-table tbody input[type="checkbox"]:checked').length;
        if (checkedCount > 0) {
            $('#massDeleteBtnLocations').show();
        } else {
            $('#massDeleteBtnLocations').hide();
        }
    });

    $('#massDeleteBtnLocations').click(function () {
        var locationIds = [];
        $('#locations-table tbody input[type="checkbox"]:checked').each(function () {
            locationIds.push($(this).val());
        });

        if (locationIds.length === 0) {
            alert("Nenhuma localização selecionada.");
            return;
        }

        if (confirm("Tem certeza que deseja excluir os locais selecionados?")) {
            var deletePromises = locationIds.map(function (id) {
                return $.ajax({
                    url: 'https://soccer-system.azurewebsites.net/api/locations/' + id,
                    method: 'DELETE',
                    dataType: 'json'
                });
            });

            $.when.apply($, deletePromises).done(function () {
                alert("Locais removidos com sucesso!");
                $('#massDeleteBtnLocations').hide();
                listLocations(currentPage);
            }).fail(function (err) {
                console.error('Erro ao remover locais: ', err);
            });
        }
    });

});