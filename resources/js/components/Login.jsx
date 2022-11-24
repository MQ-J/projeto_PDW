// importando aquela coisa de estado
import {useState, useEffect} from "react";

//carregando
import ClipLoader from "react-spinners/ClipLoader";

// para redirecionar
import {useNavigate} from "react-router-dom";

// -------------------------------------

export default function Login() {
    //gif de carregando
    let [loading, setLoading] = useState(false);

    // para acessar módulo Home
    const navigate = useNavigate();

    // caso já tenha login, vai pro home
    localStorage.getItem("token") ?
        useEffect(() => {
            navigate(localStorage.getItem("user"))
        }, [])
        : console.log("faça o login")

    // className da msg de login incorreto
    const [loginError, setLoginError] = useState("d-none");

    // FUNÇÃO PARA FAZER LOGIN
    const auth = async (event) => {
        event.preventDefault();
        setLoading(true)

        const url = process.env.NODE_ENV == "development" ? "http://127.0.0.1:8000" : "https://polar-shelf-77439.herokuapp.com"
        const formData = new FormData(event.target);

        try {
            const {data} = await axios.post(`${url}/api/auth`, formData);

            localStorage.setItem("token", data.token);

            navigate(event.target.name.value)
        } catch (e) {
            setLoading(false)
            setLoginError("alert alert-danger")
        }
    };

    return (
        <div>
            <NewUserModal loading={loading} setLoading={setLoading}/>

            <div className="d-flex justify-content-center">
                <div className="col-md-6 col-11">
                    <h2 className="text-center pt-3">Entre na sua conta</h2>

                    <div className="d-flex flex-column aligns-items-center justify-content-center pt-3 gap-3">

                        <div className="border border-secondary rounded p-2 bg-cadet">
                            <div className={loginError} role="alert">Login Incorreto</div>

                            <Form auth={auth} loading={loading} setLoading={setLoading}/>
                        </div>

                        <div
                            className="d-flex justify-content-between align-items-center border border-secondary rounded p-2 bg-cadet">
                            <div className="w-50">Primeira vez aqui?</div>

                            <button type="button" className="btn text-white bg-orange" data-bs-toggle="modal"
                                    data-bs-target="#newUserModal">
                                Criar conta
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    );
}

function NewUserModal(props) {

    // className da msg de login incorreto
    const [newUserError, setNewUserError] = useState(["d-none", "a"]);

    // FUNÇÃO PARA CRIAR USUÁRIO
    const newUser = async (event) => {
        let code = event.target.code.value

        if (event.target.pwd.value === event.target.pwd2.value) {

            props.setLoading(true)

            const url = process.env.NODE_ENV == "development" ? "http://127.0.0.1:8000" : "https://polar-shelf-77439.herokuapp.com"

            try {
                await axios.post(`${url}/api/user`, new FormData(event.target));
            } catch (err) {
                setNewUserError(["d-inline-block alert alert-danger w-75", res['message']]) // aqui se trata todas as respostas Nok da API
            }

            props.setLoading(false)

        } else {
            setNewUserError(["d-inline-block alert alert-danger w-75", "dados inválidos"])
        }

        event.preventDefault();
    };

    return (
        <div className="modal fade" id="newUserModal" tabIndex="-1" aria-labelledby="modal de novo usuário"
             aria-hidden="true">
            <div className="modal-dialog">
                <div className="modal-content bg-gunmetal">
                    <div className="modal-header bg-cadet border-3 border-dark">
                        <h5 className="modal-title">Novo Usuário</h5>
                        <button type="button" className="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div className="modal-body m-3">
                        <Form newUser={newUser} loading={props.loading} setLoading={props.setLoading}/>
                    </div>
                    <div className="d-flex justify-content-between modal-footer border-3 border-dark">
                        <button type="button" className="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <div className={newUserError[0]} role="alert">{newUserError[1]}</div>
                    </div>
                </div>
            </div>
        </div>
    )
}

function Form(props) {

    return (
        <form onSubmit={props.auth ? props.auth : props.newUser}>

            <div className="mb-3">
                <label htmlFor="name" className="form-label">Usuário:</label>
                <input type="text" name="name" className="form-control" required/>
            </div>

            <div className="mb-3">
                <label htmlFor="pwd" className="form-label">Senha:</label>
                <input type="password" name="pwd" className="form-control" required/>
            </div>

            {props.auth ? "" :
                <>
                    <div className="mb-3">
                        <label htmlFor="pwd2" className="form-label">Confirmar senha:</label>
                        <input type="password" name="pwd2" className="form-control" required/>
                    </div>

                    <div className="mb-3">
                        <label htmlFor="email" className="form-label">Email:</label>
                        <input type="email" name="email" className="form-control" required/>
                    </div>
                </>
            }

            <button type="submit" className="btn text-white bg-orange w-100">
                {
                    !props.loading ?
                        (
                            props.auth ? "Login" : "Criar usuário"
                        ) :
                        (
                            <ClipLoader
                                color={"#ffffff"}
                                loading={props.loading}
                                cssOverride={{display: "block", margin: "0 auto"}}
                                size={20}
                            />
                        )
                }
            </button>
        </form>
    )
}
