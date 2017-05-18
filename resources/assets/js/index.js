// @flow

import Inferno from "inferno";
import domready from "domready";
import Hello from "Components/hello";

domready (() => {
    const name = "Laravel";
    Inferno.render(
        <Hello myName={ name }/>,
        document.getElementById('app')
    );
});
