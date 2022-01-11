import { useParams, useNavigate } from "react-router-dom"
import Back from "../../Back";

function CowUpdate() {
    const { ID } = useParams();
    const nav = useNavigate();
    console.log(ID)
    if(!ID){
        nav('/cows', {replace:true})
    }
    return (
        <div>
            <Back link={`/cows/${ID}`} />
            <h2>Update</h2>
            {ID}
        </div>
    )
}

export default CowUpdate
