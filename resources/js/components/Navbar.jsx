// para redirecionar
import { Link } from "react-router-dom";

// importando aquela coisa de estado
import { useState } from "react";

//carregando
import ClipLoader from "react-spinners/ClipLoader";

// -------------------------------------

export function Navbar(props) {

    //email
    const email = localStorage.getItem("email")

    //versão do site
    const { version: appVersion } = require('./../../../package.json');

    //gif de carregando
    let [loading, setLoading] = useState(false);

    //editar menus
    let [alteraMenu, isAlteraMenu] = useState(false)

    // controla o logout
    const url = process.env.NODE_ENV == "development" ? "/" : "/ReactMobile/dist"
    const removeLogin = () => {
        localStorage.removeItem("user")
        localStorage.removeItem("menu")
        localStorage.removeItem("email")
        localStorage.removeItem("currentmenu")
        location = url
    }

    // apaga a conta atual
    const deleteUser = () => {

        const host = process.env.NODE_ENV == "development" ? "http://127.0.0.1:8000" : "https://polar-shelf-77439.herokuapp.com"

        var formData = new FormData();
        formData.append('name', props.user);

        if (confirm("deseja mesmo apagar sua conta, incluindo TODAS as suas anotações ?")) {
            fetch(
                `${host}/api/ReactMobile/deleteUser`,
                {
                    body: new URLSearchParams(formData),
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                    },
                    method: "post",
                }
            ).then((res) => res.json()).then((res) => {

                if (res['status'] == 'ok') {
                    removeLogin()

                } else {
                    alert(res['message']) // aqui se trata todas as respostas Nok da API
                }
            }
            );
        }
    }

    // cria menu
    const addMenu = (event) => {

        setLoading(true)

        const url = process.env.NODE_ENV == "development" ? "http://127.0.0.1:8000" : "https://polar-shelf-77439.herokuapp.com"

        fetch(
            `${url}/api/ReactMobile/newMenu`,
            {
                body: new URLSearchParams(new FormData(event.target)),
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                method: "post",
            }
        ).then((res) => res.json()).then((res) => {

            if (res['status'] == 'ok') {
                setLoading(false)
                removeLogin()
            } else {
                setLoading(false)
                alert(res['message'])
            }
        }
        );

        event.preventDefault();
    };

    // apaga menu
    const deleteMenu = (menu, code, user) => {
        if (confirm("quer mesmo apagar o menu " + menu + "?")) {

            const url = process.env.NODE_ENV == "development" ? "http://127.0.0.1:8000" : "https://polar-shelf-77439.herokuapp.com"

            var formData = new FormData()
            formData.append('name', user)
            formData.append('code', code)

            fetch(
                `${url}/api/ReactMobile/deleteMenu`,
                {
                    body: new URLSearchParams(formData),
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                    },
                    method: "post",
                }
            ).then((res) => res.json()).then((res) => {

                if (res['status'] == 'ok') {
                    removeLogin()
                } else {
                    setLoading(false)
                    alert(res['message'])
                }
            }
            );
        }
    }

    return (
        <>
            {/*  Modal de usuário  */}
            <div
                className="modal fade"
                id="modalUser"
                tabIndex="-1"
                aria-labelledby="modalLabel"
                aria-hidden="true"
            >
                <div className="modal-dialog modal-dialog-scrollable">
                    <div className="modal-content bg-gunmetal">

                        <div className="modal-header bg-cadet border-3 border-dark">
                            <h5 className="modal-title" id="modalLabel">
                                Configurações
                            </h5>
                            <button
                                type="button"
                                className="btn-close"
                                data-bs-dismiss="modal"
                                aria-label="Close"
                            ></button>
                        </div>

                        <div className="modal-body">
                            <h5>Informações pessoais</h5>
                            <ul>
                                <li><b>Usuário: </b>{props.user}</li>
                                <li><b>Email: </b>{email}</li>
                            </ul>
                            <hr />
                            <h5>Sobre este site</h5>
                            <ul>
                                <li>Código fonte: <a className="btn btn-outline-success p-0" role="button" href="https://github.com/MQ-J/ReactMobile">ReactMobile</a> </li>
                                <li>Versão: {appVersion}</li>
                                <li>Desenvolvedor: <a className="btn btn-outline-success p-0" role="button" href="https://github.com/MQ-J">MQJ</a> </li>
                            </ul>
                            <hr />
                            <h5>Apagar minha conta</h5>
                            <p>Tenha em mente que isso apagará <b>todas as suas anotações</b>, junto com seu email, senha e usuário.</p>
                            <button
                                type="button"
                                className="btn btn-danger"
                                onClick={deleteUser}
                            >
                                Apagar minha conta
                            </button>
                        </div>

                        <div className="modal-footer border-3 border-dark">
                            <button
                                type="button"
                                className="btn btn-secondary"
                                data-bs-dismiss="modal"
                                onClick={removeLogin}
                            >
                                Logout
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {/*  Modal de menu  */}
            <div
                className="modal fade"
                id="modalMenu"
                tabIndex="-1"
                aria-labelledby="modalLabel"
                aria-hidden="true"
            >
                <div className="modal-dialog modal-dialog-scrollable">
                    <div className="modal-content bg-gunmetal">

                        <div className="modal-header bg-cadet border-3 border-dark">
                            <h5 className="modal-title">
                                Criar tópico
                            </h5>
                            <button
                                type="button"
                                className="btn-close"
                                data-bs-dismiss="modal"
                                aria-label="Close"
                            ></button>
                        </div>

                        <form onSubmit={addMenu}>

                            <div className="modal-body">
                                <div className="input-group d-flex justify-content-around align-items-center w-75">
                                    <label htmlFor="nome">Nome:</label>
                                    <input
                                        type="text"
                                        name="nome"
                                        className="form-control m-1 w-50"
                                        required
                                    />
                                </div>
                                <input
                                    type="text"
                                    name="user"
                                    value={props.user}
                                    readOnly
                                    hidden
                                />
                                <input
                                    type="text"
                                    name="code"
                                    value={Math.random().toString(32).substr(2, 9)}
                                    readOnly
                                    hidden
                                />

                                <div className="pt-2">Será necessário logar novamente após criar um novo tópico</div>
                            </div>

                            <div className="modal-footer border-3 border-dark gap-2">

                                <button type="submit" className="btn text-white bg-orange">
                                    {loading ? (
                                        <ClipLoader color={"#ffffff"} loading={loading} cssOverride={{ display: "block", margin: "0 auto" }} size={20} />
                                    ) : (
                                        "Criar"
                                    )}
                                </button>

                                <button
                                    type="button"
                                    className="btn btn-secondary"
                                    data-bs-dismiss="modal"
                                >
                                    Voltar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {/* Barra de navegação */}
            <nav className="navbar navbar-expand-lg justify-content-around mb-2 bg-cadet" >

                <div className="container-fluid">

                    {/* sanduíche-íche */}
                    <button className="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" className="bi bi-list" viewBox="0 0 16 16">
                            <path fillRule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
                        </svg>
                    </button>

                    {/* icone de usuário */}
                    < button
                        className="btn p-2 me-3"
                        data-bs-toggle="modal"
                        data-bs-target="#modalUser"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="32"
                            height="32"
                            fill="currentColor"
                            className="bi bi-person-circle"
                            viewBox="0 0 16 16"
                        >
                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                            <path
                                fillRule="evenodd"
                                d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"
                            />
                        </svg>
                    </button >

                    {/* parte que abre e fecha */}
                    <div className="collapse navbar-collapse" id="navbarScroll">
                        <ul className="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style={{ "--bs-scroll-height": "50vh" }}>

                            {/* editar menus */}
                            <li className="nav-item border border-dark rounded-pill d-flex justify-content-around me-2" style={{ width: "95px" }}>
                                <button
                                    className="btn btn-link link-success"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalMenu"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" className="bi bi-plus-circle" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                                    </svg>
                                </button>

                                <button
                                    className="btn btn-link link-warning"
                                    onClick={() => isAlteraMenu(!alteraMenu)}
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" className="bi bi-pencil-square" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                        <path fillRule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                    </svg>
                                </button>
                            </li>

                            {/* lista de menus */}
                            {localStorage.getItem("menu").split(" ").map((content, index) => {
                                if (content != "") {
                                    let cont = content.split(";")
                                    let menu = cont[0]
                                    let code = cont[1]
                                    if (!alteraMenu) {
                                        return (
                                            <li className="nav-item" key={index}>
                                                <Link
                                                    className="nav-link link-dark p-2"
                                                    to={`/${props.user}/${code}`}
                                                    onClick={() => {
                                                        localStorage.setItem("currentmenu", menu)
                                                    }}
                                                >
                                                    {menu}
                                                </Link>
                                            </li>
                                        )
                                    } else {
                                        return (
                                            <li className="nav-item m-1" key={index} style={{ width: "200px" }}>

                                                <form className="input-group" onSubmit={addMenu}>
                                                    <input
                                                        type="text"
                                                        name="nome"
                                                        className="form-control bg-cadet border border-dark"
                                                        defaultValue={menu}
                                                        required
                                                    />
                                                    <input
                                                        type="text"
                                                        name="user"
                                                        value={props.user}
                                                        readOnly
                                                        hidden
                                                    />
                                                    <input
                                                        type="text"
                                                        name="code"
                                                        value={code}
                                                        readOnly
                                                        hidden
                                                    />
                                                    <button className="btn btn-link border border-dark" type="submit">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" className="bi bi-check-circle text-success" viewBox="0 0 16 16">
                                                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                                            <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z" />
                                                        </svg>
                                                    </button>
                                                    <button className="btn btn-link border border-dark" onClick={() => deleteMenu(menu, code, props.user)} type="button" id={"alter" + menu}>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" className="bi bi-dash-circle text-danger ms-2" viewBox="0 0 16 16">
                                                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                                            <path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </li>
                                        )
                                    }
                                }
                            })}

                            {/* demais coisas */}
                            <li className="nav-item dropdown">
                                <a className="nav-link link-dark dropdown-toggle p-2" href="resources/js/components/Navbar#" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    features
                                </a>
                                <ul className="dropdown-menu bg-cadet" aria-labelledby="navbarScrollingDropdown">
                                    <table className="table table-hover m-0">
                                        <tbody>
                                            <tr>
                                                <Link className="nav-link link-dark p-2" to={`/${props.user}`}>
                                                    Sobre este site
                                                </Link>
                                            </tr>
                                            <tr>
                                                <Link className="nav-link link-dark p-2" to={`/${props.user}/Respect`}>
                                                    Respeito aos pais
                                                </Link>
                                            </tr>
                                            <tr>
                                                <Link className="nav-link link-dark p-2" to={`/${props.user}/StarWars`}>
                                                    StarWars
                                                </Link>
                                            </tr>
                                        </tbody>
                                    </table>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </>
    );
}
