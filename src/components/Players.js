import React from "react";

import Top from './Top';

import Menu from './Menu';

function Players() {
    return (
        <>
            <Top />
            <div className="container-fluid">
                <div className="row">
                    <Menu />
                    <div className="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                        {/* start Content*/}
                        
                        <div>
                            <section>
                                <div className="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                                    <h1 className="h2">Jogadores</h1>
                                    <div className="btn-toolbar mb-2 mb-md-0">
                                        <div className="btn-group me-2">
                                            <button type="button" className="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addPlayerModal">Cadastrar</button>
                                        </div>
                                    </div>
                                </div>
                                <div className="input-group mb-3" style={{ maxWidth: 300 }}>
                                    <input type="text" className="form-control" placeholder="Pesquisar por nome" id="search-name-player" aria-label="Pesquisar por nome" aria-describedby="button-addon2" />
                                    <button className="btn btn-primary" type="button" id="search-button-player">Buscar</button>
                                    <button className="btn btn-secondary" type="button" id="clear-search" style={{ display: 'none' }}>Limpar Filtro</button>
                                </div>
                                <div className="table-responsive small">
                                    <table className="table table-striped table-sm" id="players-table">
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
                                                <td colSpan={8}>
                                                    <button className="btn btn-danger btn-sm" id="massDeleteBtnPlayers" style={{ display: 'none' }}>Remover Selecionados</button>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <nav aria-label="Page navigation example" className="mt-4">
                                    <ul className="pagination paginationPlayers">
                                    </ul>
                                </nav>
                            </section>
                            <div className="modal fade" id="addPlayerModal" tabIndex={-1} aria-labelledby="addPlayerModalLabel" aria-hidden="true" data-bs-backdrop="static">
                                <div className="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                    <div className="modal-content">
                                        <div className="modal-header">
                                            <h5 className="modal-title" id="addPlayerModalLabel">Cadastrar Jogador</h5>
                                            <button type="button" className="btn-close" data-bs-dismiss="modal" aria-label="Close" />
                                        </div>
                                        <div className="modal-body">
                                            <form id="playerForm">
                                                <div className="mb-3">
                                                    <label htmlFor="playerName" className="form-label">Nome do Jogador</label>
                                                    <input type="text" className="form-control" id="playerName" name="playerName" maxLength={60} required />
                                                    <div id="playerNameHelp" className="form-text">Máximo de 60 caracteres.</div>
                                                </div>
                                                <div className="mb-3">
                                                    <label htmlFor="playerPosition" className="form-label">Posição</label>
                                                    <select className="form-select" id="playerPosition" name="playerPosition" required>
                                                        <option value="ATA">Atacante (ATA)</option>
                                                        <option value="MEI">Meio-campista (MEI)</option>
                                                        <option value="DEF">Defensor (DEF)</option>
                                                        <option value="GOL">Goleiro (GOL)</option>
                                                    </select>
                                                </div>
                                                <div className="mb-3">
                                                    <label htmlFor="playerLevel" className="form-label">Nível</label>
                                                    <input type="number" className="form-control" id="playerLevel" name="playerLevel" min={1} max={5} required />
                                                    <div id="playerLevelHelp" className="form-text">Mínimo 1 e Máximo 5</div>
                                                </div>
                                                <div className="mb-3">
                                                    <label htmlFor="playerAge" className="form-label">Idade</label>
                                                    <input type="number" className="form-control" id="playerAge" name="playerAge" min={0} max={99} required />
                                                </div>
                                                <button type="submit" className="btn btn-primary">Salvar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div className="modal fade" id="editPlayerModal" tabIndex={-1} aria-labelledby="editPlayerModalLabel" aria-hidden="true" data-bs-backdrop="static">
                                <div className="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                    <div className="modal-content">
                                        <div className="modal-header">
                                            <h5 className="modal-title" id="editPlayerModalLabel">Editar Jogador</h5>
                                            <button type="button" className="btn-close" data-bs-dismiss="modal" aria-label="Close" />
                                        </div>
                                        <div className="modal-body">
                                            <form id="editPlayerForm">
                                                <input type="hidden" id="editPlayerId" name="editPlayerId" />
                                                <div className="mb-3">
                                                    <label htmlFor="editPlayerName" className="form-label">Nome do Jogador</label>
                                                    <input type="text" className="form-control" id="editPlayerName" name="editPlayerName" maxLength={60} required />
                                                    <div id="editPlayerNameHelp" className="form-text">Máximo de 60 caracteres.</div>
                                                </div>
                                                <div className="mb-3">
                                                    <label htmlFor="editPlayerPosition" className="form-label">Posição</label>
                                                    <select className="form-select" id="editPlayerPosition" name="editPlayerPosition" required>
                                                        <option value="ATA">Atacante (ATA)</option>
                                                        <option value="MEI">Meio-campista (MEI)</option>
                                                        <option value="DEF">Defensor (DEF)</option>
                                                        <option value="GOL">Goleiro (GOL)</option>
                                                    </select>
                                                </div>
                                                <div className="mb-3">
                                                    <label htmlFor="editPlayerLevel" className="form-label">Nível</label>
                                                    <input type="number" className="form-control" id="editPlayerLevel" name="editPlayerLevel" min={1} max={5} required />
                                                    <div id="editPlayerLevelHelp" className="form-text">Mínimo 1 e Máximo 5</div>
                                                </div>
                                                <div className="mb-3">
                                                    <label htmlFor="editPlayerAge" className="form-label">Idade</label>
                                                    <input type="number" className="form-control" id="editPlayerAge" name="editPlayerAge" min={0} max={99} required />
                                                </div>
                                                <button type="submit" className="btn btn-primary">Salvar Alterações</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {/* End Content */}
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}

export default Players;
