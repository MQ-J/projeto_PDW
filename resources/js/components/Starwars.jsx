// importando o elemento filho
import StarWarsChild from "./StarWarsChild";

// importando aquela coisa de estado
import { useState } from "react";

// para redirecionar
import { Navbar } from "./Navbar";
import { useParams } from 'react-router-dom';

// -------------------------------------

export default function StarWars() {

  // parâmetro da URL
  const {user} = useParams();

  // definindo data e a função que seta ela, sem valor inicial
  const [data, setData] = useState("");
  const [numb, setNumb] = useState(0);

  // função que define a variável data (set the data, setData, em inglês)
  const parentToChild = () => {
    setNumb(numb + 1);
    setData("Luke " + numb);
  };

  return (
    <div>
      
      <Navbar user={user}/>

      <div className="d-flex flex-column aligns-items-center justify-content-center w-50 mx-auto">
        <h2 className="text-center pt-3">Star Wars</h2>
        <p className="text-center">
          Passsando props de um módulo <b>pai</b> para <b>filho</b>
        </p>
      </div>

      {/* área do elemento filho */}
      <div className="d-flex aligns-items-center justify-content-center pt-3">
        <div className="border border-secondary rounded p-2">
          <p>Pai: Dart Vader</p>

          {/* exportando elemento filho, com a variável data como parâmetro do props 'texto' */}
          <StarWarsChild texto={data} />

          {/* botão que chama função que define a variável data */}
          <div>
            <button
              type="button"
              className="btn text-white bg-orange"
              onClick={() => parentToChild()}
            >
              Ver o filho
            </button>
          </div>
        </div>
      </div>
    </div>
  );
}