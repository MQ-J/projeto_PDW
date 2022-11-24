// para redirecionar
import {Navbar} from "./Navbar";
import {useParams} from 'react-router-dom';
import {useState, useEffect} from "react";
import "regenerator-runtime" //para async e wait funcionarem

//icone bootstrap
import "bootstrap-icons/font/bootstrap-icons.css";

//carregando
import ClipLoader from "react-spinners/ClipLoader";

// -------------------------------------

// definindo classe Filho como um Componente (isso é um componente de classe)
export default function Menu() {
    const params = useParams();

    // bloco em estado inicial
    const [numBlocos, setNumblocos] = useState([])

    //nome do menu buscado do localstorage
    const menuname = localStorage.getItem("currentmenu")

    async function getBlocos() {
        const token = localStorage.getItem("token");
        const host = process.env.NODE_ENV == "development" ? "http://127.0.0.1:8000" : "https://polar-shelf-77439.herokuapp.com"

        const {data} = await axios.get(`/api/menu/${params.menu}/block`, {
            headers: {
                "Accept": "application/json",
                "Authorization": "Bearer " + token
            }
        });

        setNumblocos(data)
    }

    useEffect(async () => {
        await getBlocos()
    }, []);

    // adiciona blocos
    const addBloco = () => {
        let bloco = {code: Math.random().toString(32).substr(2, 9), title: "titulo", "text": "texto"}
        setNumblocos(prevbloco => [bloco, ...prevbloco])
    }

    // atualiza blocos existentes
    function attBloco(event) {

        // verifica se vai mudar o título ou texto
        let type = event.target.outerHTML.substring(1, 6) == "input" ? "title" : "text"

        // cópia do state dos blocos
        let bloco = numBlocos

        // procura o bloco referente na cópia e edita
        for (var i = 0; i < bloco.length; i++) {
            if (bloco[i].code == event.target.name) {
                if (type == "title") {
                    bloco[i].title = event.target.value
                }
                if (type == "text") {
                    bloco[i].text = event.target.value
                }

                // altera o state dos blocos
                setNumblocos(() => bloco)
            }
        }
    }

    //sincroniza com o banco
    const DB = async (event) => {

        event.preventDefault();

        const token = localStorage.getItem("token");
        const host = process.env.NODE_ENV == "development" ? "http://127.0.0.1:8000" : "https://polar-shelf-77439.herokuapp.com"
        const formData = {"text": new FormData(event.target).get("texto")};

        await axios.post(`/api/menu/${params.menu}/block`, formData, {
            headers: {
                "Accept": "application/json",
                "Authorization": "Bearer " + token
            }
        });

        location.reload();


        /*fetch(
            `${host}/api/ReactMobile/updateBlocos`,
            {
                body: new URLSearchParams(formData),
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                method: "post",
            }
        ).then((res) => res.json()).then((res) => {

                if (res['status'] == 'ok') {
                    console.log(res['blocos'])
                    alert("O bloco " + event.target.title.value + " foi salvo")
                } else {
                    console.log("erro")
                    alert("erro ao salvar, contate o desenvolvedor")
                }
            }
        )*/
    }

    const deleteBloco = async (id) => {

        const token = localStorage.getItem("token");
        const host = process.env.NODE_ENV == "development" ? "http://127.0.0.1:8000" : "https://polar-shelf-77439.herokuapp.com"

        await axios.delete(`/api/menu/menu/block/${id}`,{
            headers: {
                "Accept": "application/json",
                "Authorization": "Bearer " + token
            }
        });

        location.reload();
    }

    return (
        <div>

            <Navbar/>

            {/* conteúdo */}
            <div className="d-flex flex-column aligns-items-center justify-content-center w-50 mx-auto"
                 style={{minWidth: 200}}>
                <h2 className="text-center pt-3">{menuname}</h2>
                <div className="mb-3">
                    <button type="button" className="btn btn-sm bg-cadet" onClick={addBloco}>Adicionar bloco</button>
                </div>

                {!numBlocos.length ? (
                    <ClipLoader color={"#ffffff"} loading={true} cssOverride={{display: "block", margin: "0 auto"}}
                                size={40}/>
                ) : (
                    numBlocos.map((bloco) =>
                            <div key={bloco.code} id={bloco.code} className="bg-dark w-100 mx-auto rounded my-3">
                                <form onSubmit={DB}>
                                    <textarea
                                        className="form-control bg-dark fw-light text-white border-0"
                                        rows="3"
                                        name="texto"
                                        defaultValue={bloco.text}
                                        onChange={event => attBloco(event)}>
                </textarea>
                                    <input value={bloco.code} name="code" readOnly hidden/>

                                    <div className="d-flex justify-content-end gap-3 p-2">
                                        <button className="btn btn-link link-success" type="submit"
                                                style={{backgroundColor: '#212529'}}>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                 fill="currentColor" className="bi bi-check-circle text-success"
                                                 viewBox="0 0 16 16">
                                                <path
                                                    d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                <path
                                                    d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
                                            </svg>
                                        </button>
                                        <button className="btn btn-link link-danger" type="button"
                                                onClick={() => deleteBloco(bloco.id)}
                                                style={{backgroundColor: '#212529'}}>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                 fill="currentColor" className="bi bi-dash-circle text-danger"
                                                 viewBox="0 0 16 16">
                                                <path
                                                    d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                <path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z"/>
                                            </svg>
                                        </button>
                                    </div>
                                </form>
                            </div>
                    )
                )}
            </div>
        </div>
    );
}
