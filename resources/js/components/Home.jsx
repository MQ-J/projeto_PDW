// para redirecionar
import { Navbar } from "./Navbar";
import { useParams } from 'react-router-dom';

// -------------------------------------

// definindo classe Filho como um Componente (isso é um componente de classe)
export default function Home() {

  // parâmetro da URL
  const {user} = useParams();

  return (
    <div>

      <Navbar user={user}/>

      {/* conteúdo */}
      <div className="d-flex flex-column aligns-items-center justify-content-center w-50 mx-auto">
        <h2 className="text-center pt-3">Sobre este Site</h2>
        <p className="text-justify">
          Veja bem, este site foi feito com React JS para servir como exemplo em outros projetos.
          Alguns dos conceitos aplicados foram:
        </p>
        <ul>
          <li>Componentização</li>
          <li>Router, Navigate, useEffect, useParams</li>
          <li>Props e State</li>
          <li>Comunicação com backend em Laravel usando Fetch (API's)</li>
          <li>Integração com banco de dados PostgreSQL</li>
        </ul>
        <hr />
        <h5>Tecnologias utilizadas</h5>
        <ul>
          <li><a className="text-decoration-none text-bootstrap" href="resources/js/components/Home">Bootstrap 5</a></li>
          <li><a className="text-decoration-none text-react" href="resources/js/components/Home">React JS</a></li>
          <li><a className="text-decoration-none text-laravel" href="resources/js/components/Home">Laravel</a></li>
          <li><a className="text-decoration-none text-elehantsql" href="resources/js/components/Home">ElephantSQL</a></li>
        </ul>
      </div>
    </div>
  );
}
