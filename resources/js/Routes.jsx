// para o sistema de rotas
import { BrowserRouter as Router, Navigate, Route, Routes } from "react-router-dom";

// módulos
import Home from "./components/Home";
import Login from "./components/Login";
import Respect from "./components/Respect";
import StarWars from "./components/Starwars";
import Menu from "./components/Menu";
import { Footer } from "./components/Footer";


export function AppRouter() {

  const basename = process.env.NODE_ENV == "development" ? "" : "/ReactMobile/dist"

  return(
    <div>

      {/* Controlador de rotas */}
      <Router basename={basename}>

        {/* Páginas que as rotas trazem */}
        <Routes>
            <Route path="/" element={localStorage.getItem("token") ? <Home /> : <Navigate to="/login"/>} />
            <Route path="/login" element={<Login/>} />
            <Route path="/:user/:menu" element={<Menu />} />
        </Routes>
      </Router>

      {/* <Footer /> */}
    </div>
  )
}
