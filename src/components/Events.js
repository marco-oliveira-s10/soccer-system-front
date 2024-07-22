import React from "react";

import Top from './Top';

import Menu from './Menu';


function Events() {
    return (
        <>
            <Top />
            <div className="container-fluid">
                <div className="row">
                    <Menu />
                    <div className="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                        {/* Start Content */}

                        <section>
                            <div className="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                                <h1 className="h2">Eventos</h1>
                                <div className="btn-toolbar mb-2 mb-md-0">
                                    <div className="btn-group me-2">
                                        <button type="button" className="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addeventModal">Cadastrar</button>
                                    </div>
                                </div>
                            </div>
                            <div className="input-group mb-3" style={{ maxWidth: 300 }}>
                                <input type="text" className="form-control" placeholder="Pesquisar por nome" id="search-name-event" aria-label="Pesquisar por nome" aria-describedby="button-addon2" />
                                <button className="btn btn-primary" type="button" id="search-button-event">Buscar</button>
                                <button className="btn btn-secondary" type="button" id="clear-search" style={{ display: 'none' }}>Limpar Filtro</button>
                            </div>
                            <div className="table-responsive small">
                                <table className="table table-striped table-sm" id="events-table">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Id</th>
                                            <th scope="col">Nome</th>
                                            <th scope="col">Localização</th>
                                            <th scope="col">Data</th>
                                            <th scope="col">Ver</th>
                                            <th scope="col">Remover</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colSpan={8}>
                                                <button className="btn btn-danger btn-sm" id="massDeleteBtnEvents" style={{ display: 'none' }}>Remover Selecionados</button>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <nav aria-label="Page navigation example" className="mt-4">
                                    <ul className="pagination paginationEvents">
                                    </ul>
                                </nav>
                        </section>
                        <div className="modal fade" id="addeventModal" tabIndex={-1} aria-labelledby="addeventModalLabel" aria-hidden="true" data-bs-backdrop="static">
                            <div className="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div className="modal-content">
                                    <div className="modal-header">
                                        <h5 className="modal-title" id="addeventModalLabel">Cadastrar Evento</h5>
                                        <button type="button" className="btn-close" data-bs-dismiss="modal" aria-label="Close" />
                                    </div>
                                    <div className="modal-body">
                                        <form id="eventoForm">
                                            <div id="etapa1" className="etapa">
                                                <div className="mb-3">
                                                    <label htmlFor="nomeEvento" className="form-label">Nome do Evento</label>
                                                    <input type="text" className="form-control" id="nomeEvento" required />
                                                </div>
                                                <div className="mb-3">
                                                    <label htmlFor="localEvento" className="form-label">Local do Evento</label>
                                                    <select className="form-select" id="localEvento" required>
                                                    </select>
                                                </div>
                                                <div className="mb-3">
                                                    <label htmlFor="dataEvento" className="form-label">Data do Evento</label>
                                                    <input type="date" className="form-control" id="dataEvento" required />
                                                </div>
                                                <button type="button" className="btn btn-primary m-1" id="btnEtapa1">Avançar</button>
                                            </div>
                                            <div id="etapa2" className="etapa" style={{ display: 'none' }}>
                                                <h2>Confirmar players</h2>
                                                <table className="table table-striped" id="playersTable">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col"><input type="checkbox" id="selectAll" /></th>
                                                            <th scope="col">Nome</th>
                                                            <th scope="col">Posição</th>
                                                            <th scope="col">Nível</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                                <div id="errorEtapa2" className="alert alert-danger" style={{ display: 'none' }} />
                                                <button type="button" className="btn btn-primary m-1" id="btnVoltarEtapa2">Voltar</button>
                                                <button type="button" className="btn btn-primary m-1" id="btnEtapa2">Avançar</button>
                                            </div>
                                            <div id="etapa3" className="etapa" style={{ display: 'none' }}>
                                                <div id="timesSorteados">
                                                </div>
                                                <button type="button" className="btn btn-primary m-1" id="btnVoltarEtapa3">Voltar</button>
                                                <button type="button" className="btn btn-primary m-1" id="sortearNovamenteBtn">Sortear Novamente</button>
                                                <button type="button" className="btn btn-success m-1" id="salvarEventoBtn">Salvar Evento</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div className="modal fade" id="vieweventModal" tabIndex={-1} aria-labelledby="vieweventModalLabel" aria-hidden="true" data-bs-backdrop="static">
                            <div className="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div className="modal-content">
                                    <div className="modal-header">
                                        <h5 className="modal-title" id="vieweventModalLabel">Ver Evento</h5>
                                        <button type="button" className="btn-close" data-bs-dismiss="modal" aria-label="Close" />
                                    </div>
                                    <div className="modal-body">
                                        <form id="viewEventoForm">
                                            <div className="mb-3">
                                                <label htmlFor="nomeEventoView" className="form-label">Nome do Evento</label>
                                                <input type="text" className="form-control" id="nomeEventoView" readOnly disabled />
                                            </div>
                                            <div className="mb-3">
                                                <label htmlFor="localEventoView" className="form-label">Local do Evento</label>
                                                <input type="text" className="form-control" id="localEventoView" readOnly disabled />
                                            </div>
                                            <div className="mb-3">
                                                <label htmlFor="dataEventoView" className="form-label">Data do Evento</label>
                                                <input type="date" className="form-control" id="dataEventoView" readOnly disabled />
                                            </div>
                                            <div id="timesSorteadosView" />
                                        </form>
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

export default Events;
