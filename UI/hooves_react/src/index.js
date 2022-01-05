import { render } from "react-dom";
import {
  BrowserRouter,
  Routes,
  Route
} from "react-router-dom";
import './css/index.css';
import App from "./App";
import Home from "./components/routes/Home";
import CompAdd from "./components/routes/Companies/CompAdd";
import CowsList from "./components/routes/Cows/CowsList";
import CowsAdd from "./components/routes/Cows/CowsAdd";
import Cows from "./components/routes/Cows/Cows";
import Cow from "./components/routes/Cows/Cow";


import NotFound from "./components/routes/NotFound";



const rootElement = document.getElementById("root");
render(
  <BrowserRouter>
    <Routes>
      <Route path='/companies/add' element={<CompAdd/>}/>
      <Route path="/" element={<App />}>
        <Route index element={<Home />} />
        <Route path="cows" element={<Cows />} >
          <Route index element={<CowsList />} />
          <Route path="add" element={<CowsAdd/> } />
          <Route path=":id" element={<Cow/> } />
        </Route>
        <Route path='*' element={<NotFound />} />
      </Route>
    </Routes>
  </BrowserRouter>,
  rootElement
);