// parece que isso já inclui o negócio de componente
import { Component } from "react";

// --------------------------------

export default class RespectChild extends Component {
  // função do filho que altera valor do pai
  funcaoDoFilho = (event) => {
    this.props.funcaoDoPai(event.target.pedebença.value);

    // impede que o formulário recarregue a página
    event.preventDefault();
  };

  render() {
    return (
      <form onSubmit={this.funcaoDoFilho}>
        <div className="d-flex justify-content-around align-items-center">
          <label htmlFor="pedebença">Filho:</label>
          <input
            type="text"
            name="pedebença"
            placeholder="msg ao pai"
            className="form-control m-1 w-50"
          />
        </div>

        <div className="mx-auto w-50 mt-2">
          <button type="submit" className="btn text-white bg-orange">
            Pedir bença
          </button>
        </div>
      </form>
    );
  }
}