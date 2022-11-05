// importando o negócio de componente, pq não sei usar componente funcional ainda
import { Component } from "react";

// -------------------------------------

// definindo classe Filho como um Componente (isso é um componente de classe)
export default class StarWarsChild extends Component {
  render() {
    return (
      <div>
        {/* usando o props texto, lá do Pai (Parent) */}
        <p> Filho: {this.props.texto} </p>
      </div>
    );
  }
}