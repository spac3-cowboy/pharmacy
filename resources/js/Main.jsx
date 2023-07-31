import "./bootstrap";
// Render your React component instead
import React from 'react';
import ReactDOM from 'react-dom';
import {
    BrowserRouter
} from "react-router-dom";
import POS from "./Application/POS/POS.tsx";


ReactDOM.render(
    <BrowserRouter>
        <POS />
    </BrowserRouter>
    ,document.querySelector('#app')
);
