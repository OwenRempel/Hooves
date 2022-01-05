import { render } from "react-dom";
import {
  BrowserRouter,
  Routes,
  Route
} from "react-router-dom";
import './index.css';
import App from "./App";
import Home from "./components/routes/Home";
import Companies from './components/routes/Companies/Companies';
import CompAdd from "./components/routes/Companies/CompAdd";
import Company from './components/routes/Companies/Company';
import CompList from "./components/routes/Companies/CompList";


import NotFound from "./components/routes/NotFound";


const rootElement = document.getElementById("root");
render(
  <BrowserRouter>
    <Routes>
      <Route path="/" element={<App />}>
        <Route index element={<Home />} />
        <Route path="companies" element={<Companies />} >
          <Route index element={<CompList />} />
          <Route path="add" element={<CompAdd/> } />
          <Route path=":id" element={<Company/> } />
        </Route>
        <Route path='*' element={<NotFound />} />
      </Route>
    </Routes>
  </BrowserRouter>,
  rootElement
);