import React from "react";

import Top from './Top';

import Menu from './Menu';


function Locations() {
    return (
        <>
            <Top />
            <div className="container-fluid">
                <div className="row">
                    <Menu />
                    <div className="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                        {/* Start Content */}
                        
                        <div>
                            <section>
                                <div className="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                                    <h1 className="h2">Locais</h1>
                                    <div className="btn-toolbar mb-2 mb-md-0">
                                        <div className="btn-group me-2">
                                            <button type="button" className="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addlocationModal">Cadastrar</button>
                                        </div>
                                    </div>
                                </div>
                                <div className="input-group mb-3" style={{ maxWidth: 300 }}>
                                    <input type="text" className="form-control" placeholder="Pesquisar por nome" id="search-name-location" aria-label="Pesquisar por nome" aria-describedby="button-addon2" />
                                    <button className="btn btn-primary" type="button" id="search-button-location">Buscar</button>
                                    <button className="btn btn-secondary" type="button" id="clear-search" style={{ display: 'none' }}>Limpar Filtro</button>
                                </div>
                                <div className="table-responsive small">
                                    <table className="table table-striped table-sm" id="locations-table">
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
                                                <td colSpan={8}>
                                                    <button className="btn btn-danger btn-sm" id="massDeleteBtnLocations" style={{ display: 'none' }}>Remover Selecionados</button>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <nav aria-label="Page navigation example" className="mt-4">
                                    <ul className="pagination paginationLocations">
                                    </ul>
                                </nav>
                            </section>
                            {/* Modal de Cadastro */}
                            <div className="modal fade" id="addlocationModal" tabIndex={-1} aria-labelledby="addlocationModalLabel" aria-hidden="true" data-bs-backdrop="static">
                                <div className="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                    <div className="modal-content">
                                        <div className="modal-header">
                                            <h5 className="modal-title" id="addlocationModalLabel">Cadastrar Local</h5>
                                            <button type="button" className="btn-close" data-bs-dismiss="modal" aria-label="Close" />
                                        </div>
                                        <div className="modal-body">
                                            <form id="locationForm">
                                                <div className="mb-3">
                                                    <label htmlFor="locationName" className="form-label">Nome</label>
                                                    <input type="text" className="form-control" id="locationName" name="locationName" maxLength={60} required />
                                                    <div id="locationNameHelp" className="form-text">Máximo de 60 caracteres.</div>
                                                </div>
                                                <div className="mb-3">
                                                    <label htmlFor="locationLocationName" className="form-label">Nome do Local</label>
                                                    <input type="text" className="form-control" id="locationLocationName" name="locationLocationName" maxLength={60} required />
                                                    <div id="locationLocationNameHelp" className="form-text">Máximo de 60 caracteres.</div>
                                                </div>
                                                <div id="formError" className="text-danger" style={{ display: 'none' }}>Todos os campos são obrigatórios.</div>
                                                <button type="submit" className="btn btn-primary">Salvar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {/* Modal de Edição */}
                            <div className="modal fade" id="editlocationModal" tabIndex={-1} aria-labelledby="editlocationModalLabel" aria-hidden="true" data-bs-backdrop="static">
                                <div className="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                    <div className="modal-content">
                                        <div className="modal-header">
                                            <h5 className="modal-title" id="editlocationModalLabel">Editar Local</h5>
                                            <button type="button" className="btn-close" data-bs-dismiss="modal" aria-label="Close" />
                                        </div>
                                        <div className="modal-body">
                                            <form id="editlocationForm">
                                                <input type="hidden" id="editlocationId" name="editlocationId" />
                                                <div className="mb-3">
                                                    <label htmlFor="editlocationName" className="form-label">Nome</label>
                                                    <input type="text" className="form-control" id="editlocationName" name="editlocationName" maxLength={60} required />
                                                    <div id="editlocationNameHelp" className="form-text">Máximo de 60 caracteres.</div>
                                                </div>
                                                <div className="mb-3">
                                                    <label htmlFor="editlocationLocationName" className="form-label">Nome do Local</label>
                                                    <input type="text" className="form-control" id="editlocationLocationName" name="editlocationLocationName" maxLength={60} required />
                                                    <div id="editlocationLocationNameHelp" className="form-text">Máximo de 60 caracteres.</div>
                                                </div>
                                                <button type="submit" className="btn btn-primary">Salvar Alterações</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {/* End Content */}
                    </div>
                </div>
            </div>
        </>
    );
}

export default Locations;
