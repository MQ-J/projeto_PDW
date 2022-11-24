// para redirecionar
import {Link} from "react-router-dom";

// importando aquela coisa de estado
import {useState, useEffect} from "react";

//carregando
import ClipLoader from "react-spinners/ClipLoader";

import BootstrapNavbar from "react-bootstrap/Navbar";
import Nav from "react-bootstrap/Nav";
import Container from "react-bootstrap/Container";
import Modal from "react-bootstrap/Modal";
import Form from "react-bootstrap/Form";
import Button from "react-bootstrap/Button";

// -------------------------------------

export function Navbar() {
    const token = localStorage.getItem("token");
    const [menus, setMenus] = useState([]);
    const [modal, setModal] = useState(false);

    useEffect(async () => {
        const {data} = await axios.get("/api/menu", {
            headers: {
                "Accept": "application/json",
                "Authorization": "Bearer " + token
            }
        });

        setMenus(data);
    }, []);

    return (
        <BootstrapNavbar bg="light" expand="lg">
            <Container>

                <BootstrapNavbar.Toggle aria-controls="basic-navbar-nav"/>
                <BootstrapNavbar.Collapse id="basic-navbar-nav">
                    <Nav className="me-auto">
                        {
                            menus.map((menu) => {
                                return <Nav.Link href={`/${menu.permalink}`}>{menu.name}</Nav.Link>;
                            })
                        }
                    </Nav>

                    <Button onClick={()=>setModal(true)}>Adicionar Menu</Button>
                </BootstrapNavbar.Collapse>
            </Container>

            <Modal
                show={modal}
                onHide={() => setModal(false)}
                dialogClassName="modal-90w"
                aria-labelledby="example-custom-modal-styling-title"
            >
                <Modal.Header closeButton>
                    <Modal.Title id="example-custom-modal-styling-title">
                        Criar Menu
                    </Modal.Title>
                </Modal.Header>
                <Modal.Body>
                    <Form onSubmit={async (evt)=>{
                        evt.preventDefault();

                        const {data} = await axios.post("/api/menu", new FormData(evt.target),{
                            headers: {
                                "Accept": "application/json",
                                "Authorization": "Bearer " + token
                            }
                        });

                        location.reload();
                    }}>
                        <Form.Group className="mb-3" controlId="formBasicPassword">
                            <Form.Label>Nome</Form.Label>
                            <Form.Control type="text" name="name"/>
                        </Form.Group>

                        <Button variant="primary" type="submit">
                            Enviar
                        </Button>
                    </Form>
                </Modal.Body>
            </Modal>
        </BootstrapNavbar>
    );
}
