import { useParams, useNavigate } from "react-router-dom"
import Back from "../../Back";


function CowDelete() {
    const { ID } = useParams();
    return (
        <div>
            <Back link={`/cows/${ID}`} />
            <h2>Delete</h2>
            {ID}
        </div>
    )
}

export default CowDelete
