import "./bootstrap";
// Render your React component instead
import React from 'react';
import ReactDOM from 'react-dom';
import {
    BrowserRouter
} from "react-router-dom";
import Purchase from "./Application/Purchase/Purchase.jsx";


ReactDOM.render(
    <BrowserRouter>
        <Purchase />
    </BrowserRouter>
    ,document.querySelector('#app')
);
