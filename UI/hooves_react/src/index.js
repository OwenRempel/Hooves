import { render } from "react-dom";
import {
  BrowserRouter,
  Routes,
  Route
} from "react-router-dom";
import App from "./App";
import Home from "./components/routes/Home";
import Companies from './components/routes/Companies';
import NotFound from "./components/routes/NotFound";

const rootElement = document.getElementById("root");
render(
  <BrowserRouter>
    <Routes>
      <Route path="/" element={<App />}>
        <Route path="companies" element={<Companies />} />
        <Route path='*' element={<NotFound />} />
      </Route>
     
    </Routes>
  </BrowserRouter>,
  rootElement
);