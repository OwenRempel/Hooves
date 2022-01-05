import * as Fields from "./FormFields";
import '../css/Form.css'
export default function Form({ form, onSubmit,}) {
    const { fields, formName, formTitle } = form;
    if (!fields) return null;

    return (
        <form onSubmit={onSubmit} className='inputForm' method="POST">
        {formTitle && <h1 className='inputTitle'>{formTitle}</h1>}
        {fields.map(({ typeName, ...field }, index) => {
            const Field = Fields[typeName];

            if (!Field) return null;

            return <Field key={index} {...field} />;
        })}

        <button className='btn' type="submit" name={formName}>Submit</button>
        </form>
  );
}