// @flow

import Inferno from 'inferno';

type Props = {
    myName: string
}

export default function(props: Props) {
    return <h1>Hello, { props.myName }</h1>;
};
